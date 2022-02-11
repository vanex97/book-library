/**
 *
 * @param firstButtonNum Number of first button.
 * @param buttonsNum Number of displayed buttons.
 * @param pageNum Active button position.
 * @param limit Number of displayed objects.
 */
function addNumberButtons(firstButtonNum, buttonsNum, pageNum, limit) {
    for (let i = 1; i <= buttonsNum; i++) {
        let itemLink = $('<a/>')
            .addClass('page-link')
            .text(firstButtonNum)
            .attr('href', '?offset=' + (firstButtonNum++ - 1) * limit);
        let item = $('<li/>')
            .addClass('page-item')
            .append(itemLink)
            .insertBefore('.item-next')
        if (pageNum === i) item.addClass('active');
    }
}

/**
 * Calculates the number of the first button relative to offset.
 * @param buttonsNum Number of displayed buttons.
 * @param offset Offset parameter.
 * @param limit Number of displayed objects.
 * @returns {number} Number of first button.
 */
function getFirstButtonNum(buttonsNum, offset, limit) {
    let res = 1;
    if (offset < (limit * buttonsNum)) {
        return res;
    }
    let buttonsOffsetStep = limit * buttonsNum;
    let lastButtonOffset = buttonsOffsetStep;

    while (offset >= lastButtonOffset) {
        lastButtonOffset += buttonsOffsetStep;
        res += buttonsNum;
    }
    return res;
}

/**
 *
 * @param firstButtonNum Number of first button.
 * @param buttonsNum Number of displayed buttons.
 * @param quantity Total number of objects.
 * @returns {number} Number of last button.
 */
function getLastButtonNum(firstButtonNum ,buttonsNum, quantity) {
    let lastButtonNum = buttonsNum;
    while ((firstButtonNum + lastButtonNum - 2) * limit  > quantity) {
        lastButtonNum--;
    }
    return lastButtonNum;
}
// Calculates range.
let firstButtonNum = getFirstButtonNum(buttonsNum, offsetValue, limit);
let lastButtonNum = getLastButtonNum(firstButtonNum ,buttonsNum, quantity);

let pageNum =((offsetValue / limit) + 1) % buttonsNum;
if (pageNum === 0) pageNum = buttonsNum;

addNumberButtons(firstButtonNum, lastButtonNum, pageNum, limit);