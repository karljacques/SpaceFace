import axios from 'axios';

const network = axios.create({
    baseURL: 'http://localhost:9501',
    headers: {
        "X-AUTH-TOKEN": "73d0e731888687f8dd1413215b5de938"
    }
});

export {network};
