import authUserReducer from './authUser'
import activeComponentReducer from './activeComponent'
import { combineReducers } from 'redux'
import constituencyReducer from "./constituency";
import voterReducer from "./voter";
//other reducers

const rootReducer = combineReducers({
    authUserReducer: authUserReducer,
    activeComponentReducer: activeComponentReducer,
    constituencyReducer: constituencyReducer,
    voterReducer: voterReducer
});

export default rootReducer;
