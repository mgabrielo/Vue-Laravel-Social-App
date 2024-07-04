
export const isImage = (attachment) => {
    if (!attachment) {
        return false;
    }
    let mime = attachment?.mime || attachment?.type
    mime = mime?.split('/')
    if (mime[0]?.toLowerCase() === 'image') {
        return true
    }
}