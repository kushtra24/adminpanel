
export default {
    state: {
    },
    actions: {

        /**
         * Logout
         * @returns {Promise<void>}
         * @constructor
         */
        async LOGOUt() {
             await axios.post("/logout");
        },


    }
};
