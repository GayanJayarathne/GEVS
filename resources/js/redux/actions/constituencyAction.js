export const saveConstituencyStateAttr = (attr, value) => {
    return {
        type: 'SAVE_CONSTITUENCY_STATE_ATTR',
        [attr]: value
    }
};
