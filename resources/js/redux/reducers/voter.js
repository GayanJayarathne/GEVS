const voterReducer = (vote=null, action) => {
    if (action) {
        switch (action?.type) {
            case 'SET_VOTER':
                const attr = Object.keys(action)[1];
                const value = Object.values(action)[1];
                return {
                    ...vote,
                    [attr]: value
                };

            default:
                return vote;
        }
    }
}

export default voterReducer;
