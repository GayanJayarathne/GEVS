const electionReducer = (start=false, action) => {
    if (action.type === 'SET_ELECTION') {
        if (action.payload !== undefined) start = action.payload;
        return start;
    } else {
        return start;
    }
}

export default electionReducer;
