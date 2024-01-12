require('../app');
import React, { useEffect } from 'react'
import ReactDOM from 'react-dom'
import { BrowserRouter, Route, Switch, Link } from 'react-router-dom'
import '../variables'
import {createStore} from 'redux';
import rootReducer from '../redux/reducers/index'
import { Provider, useDispatch, useSelector } from 'react-redux'
import rootAction from '../redux/actions/index'
import ConstituenciesResultList from "../components/commissioner/ConstituenciesResultList";

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
			{/*<BrowserRouter>*/}
			{/*<div className="page-header">*/}
			{/*	<h3 className="page-title">*/}
			{/*		<span className="page-title-icon bg-gradient-primary text-white mr-2">*/}
			{/*			<i className="mdi mdi-account-multiple"></i>*/}
			{/*		</span>*/}
			{/*	 	'Results'*/}
			{/*	</h3>*/}
			{/*	<nav aria-label="breadcrumb">*/}
			{/*			<Link to='/home' className="btn btn-social-icon-text btn-linkedin"><i className="mdi mdi-arrow-left-bold btn-icon-prepend"></i>&nbsp; Back</Link>*/}
			{/*	</nav>*/}
			{/*</div>*/}
			{/*<div className="row">*/}
			{/*	<div className="col-lg-12 grid-margin stretch-card">*/}

			{/*			<Switch>*/}
			{/*				<Route exact path='/result/constituency-list' > <ConstituenciesResultList /> </Route>*/}
			{/*			</Switch>*/}

			{/*	</div>*/}
			{/*</div>*/}
			{/*</BrowserRouter>*/}
			<ConstituenciesResultList />
		</React.Fragment>
	);
}

ReactDOM.render(
	<Provider store={myStore}>
		<App />
	</Provider>
, document.getElementById('app'))
