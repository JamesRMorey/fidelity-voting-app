import axios from "axios";

export default class Api {
    constructor() {
        axios.defaults.withCredentials = true;
        axios.defaults.baseURL = import.meta.env.VITE_API_URL;
    }

    async getCSRF() {
        return new Promise(async ( resolve, reject ) => {
            await axios.get( 'sanctum/csrf-cookie' )
            .then(( response ) => {
                const csrfToken = document.cookie
                .split('; ')
                .find((cookie) => cookie.startsWith('XSRF-TOKEN='))
                .split('=')[1];
                
                axios.defaults.headers.common['X-XSRF-TOKEN'] = csrfToken;

                resolve(csrfToken);
            }) 
            .catch(( error ) => {
                reject( error );
            })
        })
    }

    async login( email, password ) {
        return new Promise(async ( resolve, reject ) => {
            await this.getCSRF();
            await axios.post( 'login', { 
                email: email, 
                password: password 
            })
            .then(( response ) => {
                resolve( response.data );
            })
            .catch(( error ) => {
                reject( error.response.data );
            })
        })
    }

    async register( name, email, password, confirmPassword ) {
        return new Promise(async ( resolve, reject ) => {
            await axios.get( 'sanctum/csrf-cookie' )
            await axios.post( 'register', {
                name: name,
                email: email, 
                password: password, 
                password_confirmation: confirmPassword 
            } )
            .then(( response ) => {
                resolve( response.data );
            })
            .catch(( error ) => {
                reject( error.response.data );
            })
        })
    }

    async logout() {
        return new Promise(async ( resolve, reject ) => {
            await this.getCSRF();
            await axios.post( 'logout' )
            .then(( response ) => {
                resolve( response.data );
            })
            .catch(( error ) => {
                reject( error.response.data );
            })
        })
    }
}