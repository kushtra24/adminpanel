export default class Gate {

    constructor(user) {
        this.user = user;
    }

    /**
     * if is admin
     */
    isAdmin() {
        this.user.type === 'admin';
    }

    /**
     * if is User
     */
    isUser() {
        this.user.type === 'user';
    }

}
