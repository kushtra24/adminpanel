export default value => {
    if (!value) { return }
    if (value === 1) {
        return 'true'
    } else {
        return 'false'
    }
}
