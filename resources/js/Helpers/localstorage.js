const localstorage = {
    setItem: (key, value) => {
        localStorage.setItem(key, JSON.stringify(value));
    },
    getItem: async (key) => {
        return JSON.parse(localStorage.getItem(key));
    },
    verifyLocalStorage: (key) => {
        return localStorage.getItem(key) ? true : false;
    }
}

export default localstorage;