import moment from "moment";

export default date => {
    try{
        return moment(date).subtract(1, 'days').format("DD.MM.YYYY");
    } catch {
        console.error('displaying the date in the eu format was not possible maybe because it\'s null or has no value');
    }
};
