export default function auth({ next, router }) {
    if (localStorage.getItem('authenticate') == 'true') {
        return router.push({ name: 'index' });
    }
    return next();
}
