import ConstituenciesResultList from "../components/commissioner/ConstituenciesResultList";

require('../app');
import React, { useEffect } from 'react'
import ReactDOM from 'react-dom'
import { BrowserRouter, Route, Switch, Link } from 'react-router-dom'
import LeadList from '../components/SznList/LeadList'
import NewLead from '../components/SznList/NewLead'
import EditLead from '../components/SznList/EditLead'
import '../variables'
import {createStore} from 'redux';
import rootReducer from '../redux/reducers/index'
import { Provider, useDispatch, useSelector } from 'react-redux'
import rootAction from '../redux/actions/index'
import FinalResult from "../components/commissioner/FinalResult";
import ResultByConstituencies from "../components/commissioner/ResultByConstituencies";

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
			<div className="page-header">
				<h3 className="page-title">
					<span className="page-title-icon bg-gradient-primary text-white mr-2">
						{ activeComponent && activeComponent == 'LeadList' ?
						<i className="mdi mdi-account-multiple"></i> : (activeComponent && activeComponent == 'NewLead' ? <i className="mdi mdi-account-plus"></i> :
						(activeComponent && activeComponent == 'EditLead' ? <i className="mdi mdi-folder-account"></i> : activeComponent && activeComponent == 'ConstituenciesResultList'?<i className="mdi mdi-newspaper"></i>:activeComponent && activeComponent == 'FinalResult'?<i className="mdi mdi-newspaper"></i>:'' ) )
					}
					</span>
				 	{ activeComponent && activeComponent == 'LeadList' ?
						'All Candidates' : (activeComponent && activeComponent == 'NewLead' ? 'New Candidate' :
						(activeComponent && activeComponent == 'EditLead' ? 'Edit Candidate' :activeComponent && activeComponent == 'ConstituenciesResultList'?'Results': activeComponent && activeComponent == 'FinalResult'?'Final Results': '' ) )
					}
				</h3>
				<nav aria-label="breadcrumb">
					{ activeComponent && activeComponent != 'LeadList' ?
						<Link to='/home' className="btn btn-social-icon-text btn-linkedin"><i className="mdi mdi-arrow-left-bold btn-icon-prepend"></i>&nbsp; Back</Link> : <Link to='/lead/new' className="btn btn-social-icon-text btn-linkedin"><i className="mdi mdi-account-plus btn-icon-prepend"></i>&nbsp; New</Link>
					}
				</nav>
			</div>
			<div className="row">
				<div className="col-lg-12 grid-margin stretch-card">

						<Switch>
							<Route exact path='/lead/list' > <LeadList /> </Route>
							<Route path='/lead/new' > <NewLead /> </Route>
							<Route path='/lead/edit/:id' component={EditLead} />
							<Route path='/result/constituency-list' > <ConstituenciesResultList /> </Route>
							<Route path='/result/final' > <FinalResult /> </Route>
							<Route path='/result/by-constituency' > <ResultByConstituencies /> </Route>
						</Switch>

				</div>
			</div>
			</BrowserRouter>
		</React.Fragment>
	);
}

ReactDOM.render(
	<Provider store={myStore}>
		<App />
	</Provider>
, document.getElementById('app'))
