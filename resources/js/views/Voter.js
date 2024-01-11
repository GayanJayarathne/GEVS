import {BrowserRouter, Link, Route, Switch} from "react-router-dom";

require('../app');
import React, { useEffect } from 'react'
import ReactDOM from 'react-dom'
import '../variables'
import {createStore} from 'redux';
import rootReducer from '../redux/reducers/index'
import { Provider, useDispatch, useSelector } from 'react-redux'
import rootAction from '../redux/actions/index'
import VoterDashboard from "../components/voter/VoterDashboard";
import LeadList from "../components/SznList/LeadList";
import NewLead from "../components/SznList/NewLead";
import EditLead from "../components/SznList/EditLead";

//create reducer
const myStore = createStore(
    rootReducer,
    window.__REDUX_DEVTOOLS_EXTENSION__ && window.__REDUX_DEVTOOLS_EXTENSION__()
);


function App() {
    //set reducer
    const myDispatch = useDispatch();
    myDispatch(rootAction.setAuthUser(authUser)); //authUser is from blade file

    //get reducer
    const activeComponent = useSelector(state => state.activeComponentReducer);

    return (
        <React.Fragment>
            <BrowserRouter>
                <div className="row">
                    <div className="col-lg-12 grid-margin stretch-card">

                        <Switch>
                            <Route exact path='/voting-list' > <VoterDashboard/> </Route>
                        </Switch>

                    </div>
                </div>
            </BrowserRouter>
        </React.Fragment>

        // <React.Fragment>
        //     <VoterDashboard/>
        // </React.Fragment>
    );
}

ReactDOM.render(
    <Provider store={myStore}>
        <App />
    </Provider>
    , document.getElementById('app'))
