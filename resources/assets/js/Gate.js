export default class Gate{

    constructor(user){
        this.user = user;
    }

    isAdmin(){

        return this.user.user_group === 'admin';

    }

    isSupport(){

        return this.user.user_group === 'support';

    }

    isVip(){

        return this.user.user_group === 'vip';

    }

    isAdminOrAuthor(){
        if (this.user.user_group === 'admin' || this.user.user_group === 'support') {
            return true
        }
    }


}