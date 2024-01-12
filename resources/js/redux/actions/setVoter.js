export const setVoter = (attr, value) => {
    return {
        type: 'SET_VOTER',
        [attr]: value
    }
};
