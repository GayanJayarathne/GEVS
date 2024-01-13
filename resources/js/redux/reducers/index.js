import authUserReducer from './authUser'
import activeComponentReducer from './activeComponent'
import { combineReducers } from 'redux'
import constituencyReducer from "./constituency";
import voterReducer from "./voter";
import electionReducer from "./elecction";
//other reducers

const rootReducer = combineReducers({
    authUserReducer: authUserReducer,
    activeComponentReducer: activeComponentReducer,
    constituencyReducer: constituencyReducer,
    voterReducer: voterReducer,
    electionReducer: electionReducer
});

export default rootReducer;
