export default class Gate {

    constructor(user) {
        this.user = user;
    }

    /**
     * if is admin
     */
    isAdmin() {
       return this.user.type === 'admin';
    }

    /**
     * if is User
     */
    isUser() {
        return this.user.type === 'user';
    }

}
