import moment from "moment/moment";

export const simpleDate = (date, formatFrom = '') => {
    moment().locale('id')
    if (!(date instanceof moment)){
        date = formatFrom ? moment(date, formatFrom) : moment(date)
    }
    let waktu = date.format('H:m')
    let tanggal = ''

    if (!date.isSame(moment(), 'year')) {
        tanggal = date.format('D/M/YY')
    }
    else if (!date.isSame(moment(), 'day')) {
        tanggal = date.format('D MMM')
    }

    return `${tanggal ? `${tanggal} · ` : ''}${waktu}`
}

export const replaceChar = (text = '', target = '_', replacer = ' ') => {
    return text.split(target).join(replacer);
}
