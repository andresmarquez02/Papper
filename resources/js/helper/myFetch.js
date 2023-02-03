export function myFetch() {
    const consult = async(endpoint, options) => {
        let token = document.querySelector('meta#token').getAttribute('content');
        let defaultHeader = {
            accept: "application/json",
            "Content-Type": "application/json",
            'X-CSRF-TOKEN': token,
        }
        const controller = new AbortController();
        options.signal = controller.signal;

        options.method = options.method || "GET";
        options.headers = options.headers ? {...defaultHeader, ...options.headers } : defaultHeader;
        options.body = JSON.stringify(options.body) || false;

        if (!options.body) delete options.body;
        setTimeout(() => controller.abort(), 10000);

        let c = await fetch(window.location.origin + endpoint, options)
        let res = await c.json();

        if (c.status !== 500) {
            return {
                status: c.status,
                res: res
            };
        } else {
            return {
                status: c.status || "500",
                res: "Error inesperado intenta mas tarde",
            };
        }
    }
    const get = (url, options = {}) => consult(url, options);
    const post = (url, options = {}) => {
        options.method = "POST";
        return consult(url, options);
    }
    const put = (url, options = {}) => {
        options.method = "PUT";
        return consult(url, options);
    }
    const del = (url, options = {}) => {
        options.method = "DELETE";
        return consult(url, options);
    }
    return {
        get,
        post,
        put,
        del
    };
}