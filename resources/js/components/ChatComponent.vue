<template>
    <div class="tg-container">
        <div class="tg-chat-header">
            <div class="tg-user-info">
                <div class="tg-avatar">
                    <img class="gradient-border" v-if="user.user_info && user.user_info.avatar" :src="'/storage/' + user.user_info.avatar" alt="Аватар">
                    <div v-else class="tg-avatar-placeholder">Аватар</div>
                </div>
                <div class="tg-user-details">
                    <div class="tg-user-name">{{ user.user_info.first_name }} {{ user.user_info.last_name }}</div>
                    <div class="tg-user-status">
                        <span :class="{'tg-online': isUserOnline(user), 'tg-offline': !isUserOnline(user)}"></span>
                        {{ formatLastActivity(user) }}
                    </div>
                </div>
            </div>
        </div>

        <div class="tg-chat-body">
            <div v-for="message in messages" :key="message.id" :class="{'tg-message-right': message.user_id === currentUser.id, 'tg-message-left': message.user_id !== currentUser.id}" class="tg-message">
                <div class="tg-message-content">
                    {{ message.content }}
                </div>
                <div class="tg-message-footer">
                    <div class="tg-message-sender">
                        {{ message.user_id === currentUser.id ? 'Вы' : 'От ' + user.user_info.first_name }}
                    </div>
                    <div class="tg-message-time">
                        {{ formatTime(message.created_at) }}
                        <span v-if="message.user_id === currentUser.id">
                            <!-- <i v-if="message.read_at" class="fas fa-check-double tg-read"></i>
                            <i v-else class="fas fa-check-double tg-sent"></i> -->
                            <img v-if="message.read_at" src="../../../public/assets/inner-read.svg" alt="Галочка" class="small-icon" />
                            <img v-else src="../../../public/assets/inner-read.svg" alt="Галочка" class="small-icon unread" />

                        </span>
                    </div>
                </div>
                <button v-if="message.user_id === currentUser.id" @click="deleteMessage(message.id)" class="tg-delete-button">
                    <i class="fas fa-trash-alt"></i>
                </button>
            </div>
        </div>

        <form @submit.prevent="sendMessage" class="tg-chat-input">
            <input v-model="newMessage" type="text" placeholder="Введите сообщение" class="tg-input">
            <button type="submit" class="tg-send-button">
                <!-- <i class="fas fa-paper-plane"></i> -->
                <img src="../../../public/assets/Polygon 1.svg" alt="Галочка" class="polygon" width="20" height="20" />
            </button>
        </form>

        <!-- Уведомление об ошибке -->
        <div v-if="errorMessage" class="tg-error-message">
            {{ errorMessage }}
        </div>
    </div>
</template>

<script>
import moment from 'moment-timezone';
import InnerRead from '../../../public/assets/inner-read.svg';



export default {
    props: {
        user: {
            type: Object,
            required: true
        },
        initialMessages: {
            type: Array,
            required: true
        },
        currentUser: {
            type: Object,
            required: true
        },
        chatId: {
            type: Number,
            required: true
        }
    },
    data() {
        return {
            messages: this.initialMessages,
            newMessage: '',
            successMessage: '',
            errorMessage: ''
        };
    },
    mounted() {
        this.listenForNewMessages();
        moment.locale('ru');
        this.scrollToBottom();
    },
    updated() {
        this.scrollToBottom();
    },
    methods: {
        logError(message) {
            console.error('Ошибка загрузки изображения для сообщения:', message);
        },
        async sendMessage() {
            if (!this.newMessage.trim()) return;

            const tempMessage = {
                id: Date.now(),
                content: this.newMessage,
                user_id: this.currentUser.id,
                user: this.currentUser,
                created_at: new Date().toISOString(),
                read_at: null
            };

            this.messages.push(tempMessage);
            this.newMessage = '';

            try {
                const response = await axios.post(`/friends/${this.user.id}/chat/send`, {
                    content: tempMessage.content
                });

                this.successMessage = 'Сообщение отправлено.';
                setTimeout(() => {
                    this.successMessage = '';
                }, 3000);
            } catch (error) {
                console.error(error);
                this.errorMessage = 'Ошибка при отправке сообщения. Пожалуйста, попробуйте снова.';
                setTimeout(() => {
                    this.errorMessage = '';
                }, 3000);
                this.messages = this.messages.filter(m => m.id !== tempMessage.id);
            }
        },
        async deleteMessage(messageId) {
            try {
                const response = await axios.delete(`/friends/deleteMessage/${messageId}`);
                this.messages = this.messages.filter(message => message.id !== messageId);
                this.successMessage = 'Сообщение удалено.';
                setTimeout(() => {
                    this.successMessage = '';
                }, 3000);
            } catch (error) {
                console.error(error);
                this.errorMessage = 'Ошибка при удалении сообщения. Пожалуйста, попробуйте снова.';
                setTimeout(() => {
                    this.errorMessage = '';
                }, 3000);
            }
        },
        listenForNewMessages() {
            Echo.private(`chat.${this.chatId}`)
                .listen('MessageSent', (data) => {
                    if (data.message && data.message.created_at) {
                        data.message.created_at = new Date(data.message.created_at);
                    }
                    this.messages.push(data.message);
                })
                .listen('UserStatusUpdated', (data) => {
                    if (data.user.id === this.user.id) {
                        this.user = Object.assign({}, this.user, {
                            is_online: data.user.is_online,
                            last_activity_at: data.user.last_activity_at
                        });
                    }
                });
        },
        scrollToBottom() {
            const chatBody = this.$el.querySelector('.tg-chat-body');
            if (chatBody) {
                chatBody.scrollTop = chatBody.scrollHeight;
            }
        },

        formatTime(dateString) {
            if (!dateString) return '';
            const date = moment.utc(dateString).tz('Europe/Moscow'); // Преобразуем в московское время
            return date.isValid() ? date.format('HH:mm') : 'Некорректная дата';
        },

        formatLastActivity(user) {
            if (this.isUserOnline(user)) {
                return 'В сети';
            }

            if (!user.last_activity_at) {
                return 'Никогда не был(а) в сети';
            }

            const lastSeen = moment.utc(user.last_activity_at).tz('Europe/Moscow'); // Преобразуем в московское время
            const now = moment().tz('Europe/Moscow'); // Текущее время в московском часовом поясе
            const diffMinutes = now.diff(lastSeen, 'minutes');

            if (diffMinutes < 1) return 'Был(а) в сети только что';
            if (diffMinutes < 60) return `Был(а) в сети ${diffMinutes} ${this.pluralize(diffMinutes, ['минуту', 'минуты', 'минут'])} назад`;
            if (lastSeen.isSame(now, 'day')) return `Был(а) в сети сегодня в ${lastSeen.format('HH:mm')}`;
            if (lastSeen.isSame(now.subtract(1, 'day'), 'day')) return `Был(а) в сети вчера в ${lastSeen.format('HH:mm')}`;
            if (lastSeen.isAfter(now.subtract(1, 'week'))) return `Был(а) в сети ${lastSeen.format('dddd [в] HH:mm')}`;

            return `Был(а) в сети ${lastSeen.format('D MMMM YYYY [в] HH:mm')}`;
        },

        isUserOnline(user) {
            if (!user.last_activity_at) {
                return false;
            }
            const lastActive = moment.utc(user.last_activity_at).tz('Europe/Moscow'); // Преобразуем в московское время
            const now = moment().tz('Europe/Moscow'); // Текущее время в московском часовом поясе
            const diffMinutes = now.diff(lastActive, 'minutes');
            return user.is_online && diffMinutes < 5;
        },

        pluralize(number, titles) {
            const cases = [2, 0, 1, 1, 1, 2];
            return titles[
                (number % 100 > 4 && number % 100 < 20)
                    ? 2
                    : cases[Math.min(number % 10, 5)]
            ];
        }
    }
};
</script>

<style scoped>
/* Общие стили */

.unread {
  filter: grayscale(100%);
  opacity: 0.5; /* Добавьте прозрачность, если нужно */
}

.small-icon {
  width: 12px; /* Установите нужную ширину */
  height: 12px; /* Установите нужную высоту */
}

.tg-container {
    display: flex;
    flex-direction: column;
    height: 100vh;
    background-color: #e5e5e5;
    font-family: sans-serif;
}

/* Шапка чата */
.tg-chat-header {
    background-color: #f8f8f8;
    padding: 10px;
    border-bottom: 1px solid #ddd;
}

.tg-user-info {
    display: flex;
    align-items: center;
}

.tg-avatar {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    overflow: hidden;
    margin-right: 10px;
}

.tg-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.tg-avatar-placeholder {
    width: 100%;
    height: 100%;
    background-color: #ddd;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 12px;
    color: #888;
}

.tg-user-details {
    display: flex;
    flex-direction: column;
}

.tg-user-name {
    font-weight: bold;
}

.tg-user-status {
    font-size: 12px;
    color: #888;
    display: flex;
    align-items: center;
}

.tg-online {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background-color: #4caf50;
    margin-right: 5px;
}

.tg-offline {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background-color: #888;
    margin-right: 5px;
}

/* Тело чата (сообщения) */
.tg-chat-body {
    flex-grow: 1;
    padding: 10px;
    overflow-y: auto;
    display: flex;
    flex-direction: column;
    scroll-behavior: smooth; /* Плавный скроллинг */
}

/* Кастомный скроллбар */
.tg-chat-body::-webkit-scrollbar {
    width: 6px; /* Ширина скроллбара */
}

.tg-chat-body::-webkit-scrollbar-track {
    background: transparent; /* Прозрачный фон трека */
}

.tg-chat-body::-webkit-scrollbar-thumb {
    background: #888; /* Цвет ползунка */
    border-radius: 3px; /* Скругление углов */
}

.tg-chat-body::-webkit-scrollbar-thumb:hover {
    background: #555; /* Цвет ползунка при наведении */
}

.tg-message {
    max-width: 80%;
    margin-bottom: 5px;
    padding: 10px;
    border-radius: 10px;
    position: relative;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}

.tg-message:hover .tg-delete-button {
    opacity: 1; /* Показываем кнопку удаления при наведении */
}

.tg-message-left {
    align-self: flex-start;
    background-color: #fff;
    color: #000;
}

.tg-message-right {
    align-self: flex-end;
    background: #000000;
    color: #fff;
}

.tg-message-content {
    word-wrap: break-word;
    padding-bottom: 5px;
}

.tg-message-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 12px;
    color: #888;
}

.tg-message-time {
    display: flex;
    align-items: center;
}

.tg-message-time > * {
    margin-left: 3px;
}

.tg-read {
    color: #4a86e8;
    margin-left: 3px;
}

.tg-sent {
    color: #888;
    margin-left: 3px;
}

/* Метка отправителя */
.tg-message-sender {
    font-size: 9px;
    color: #888;
    padding: 0 20px 0 0;
}

/* Поле ввода сообщения */
.tg-chat-input {
    display: flex;
    padding: 10px;
    background-color: #f8f8f8;
    border-top: 1px solid #ddd;
}

.gradient-border {
        padding: 3px; /* Толщина границы */
        background: linear-gradient(45deg, #f09433 0%, #e6683c 25%, #dc2743 50%, #cc2366 75%, #bc1888 100%);
        border-radius: 50%;
    }

  
.tg-input {
    flex-grow: 1;
    padding: 8px 12px;
    border: none;
    border-radius: 7px;
    margin-right: 10px;
    font-size: 14px;
    background-color: #fff;
    outline: none;
    border: 1px solid #E5E7EB;
}

.tg-input:focus {
    border: 2px solid #2563EB;
}

.tg-send-button {
    background-color: #2563EB;
    color: white;
    border: none;
    width: 70px;
    height: 42px;
    border-radius: 7px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
}

/* Кнопка удаления */
.tg-delete-button {
    position: absolute;
    top: 50%;
    right: 10px; /* Позиция справа от сообщения */
    transform: translateY(-50%);
    background: none;
    border: none;
    color: #ff4444; /* Красный цвет иконки */
    cursor: pointer;
    opacity: 0; /* По умолчанию скрыта */
    transition: opacity 0.2s ease;
}

.tg-delete-button:hover {
    color: #ff0000; /* Красный цвет при наведении */
}

/* Уведомление об ошибке */
.tg-error-message {
    background-color: #ff4444;
    color: white;
    padding: 10px;
    border-radius: 5px;
    margin-top: 10px;
    text-align: center;
}
</style>