export default function log({ next, router }) {
    if (parseInt(localStorage.getItem("role")) !== 1) {
        return router.push({ name: 'index' });
    }
    return next();
}
