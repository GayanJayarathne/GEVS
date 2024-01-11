import React, {  useState, useEffect } from 'react'
import Pagination from "react-js-pagination";
import { useSelector, connect } from 'react-redux';
import rootAction from '../redux/actions/index'
import { fadeIn } from 'animate.css'
import 'iziToast/dist/css/iziToast.css';
import {showSznNotification} from "../Helpers";

const Dashboard = (props) => {

    const [state, setState] = useState({
       authUser: props.authUserProp,
       totalLeads: 0,
       weeklyLeads: 0,
       monthlyLeads: 0,
       recentLeads: [],
       loading: false
    });

    useEffect(() => {
        // if (typeof window !== "undefined") {
        //     const iziToast = require('iziToast');
        //
        //     iziToast.show({
        //         timeout: 0,
        //         progressBar: false,
        //         displayMode: 'once',
        //         theme: 'light',
        //         id: 'star-notification',
        //         title: '<a target="_blank" rel="noopener noreferrer" href="https://github.com/arifszn/react-laravel"><img src="https://img.shields.io/github/stars/arifszn/react-laravel?style=social" alt="Github Star"/></a>',
        //         message: 'We need your support. Please ⭐️ on <a target="_blank" rel="noopener noreferrer" href="https://github.com/arifszn/react-laravel">GitHub</a> to help us increase.'
        //     });
        // }

        props.setActiveComponentProp('Dashboard');
        if(authUser.email === "election@shangrila.gov.sr") {
            loadData();
        }else{
            loadVoterData();
        }
    }, []);

    const loadData = () => {
        setState({
            ...state,
            loading: true
        });
        axios.get('/api/v1/dashboard-data', {
            params: {
                api_token: state.authUser.api_token,
            }
        })
        .then(response => {
            setState({
                ...state,
                loading: false,
                totalLeads: response.data.message.totalLeads,
                weeklyLeads: response.data.message.weeklyLeads,
                monthlyLeads: response.data.message.monthlyLeads,
                recentLeads: response.data.message.recentLeads,
            })
        })
        .catch((error) => {
            setState({
                ...state,
                loading: false
            });
            console.log(error);
        });
    };

    const loadVoterData = () => {
        setState({
            ...state,
            loading: true
        });
        axios.get(state.authUser.email === "election@shangrila.gov.sr"?'/api/v1/dashboard-data?':'/api/v1/candidate/constituency-list?', {
            params: {
                api_token: state.authUser.api_token,
            }
        })
        .then(response => {
            setState({
                ...state,
                loading: false,
                totalLeads: response.data.message.totalLeads,
                weeklyLeads: response.data.message.weeklyLeads,
                monthlyLeads: response.data.message.monthlyLeads,
                recentLeads: response.data.message.data,
            })
        })
        .catch((error) => {
            setState({
                ...state,
                loading: false
            });
            console.log(error);
        });
    };

    const onVoteHandle = (id,name) => {

        setState({
            ...state,
            loading: true
        });

        axios.post('/api/v1/lead/updateVotes', {
            id:id,
            name:name,
            api_token: state.authUser.api_token,
        }).then(response => {
            setState({
                ...state,
                loading: false
            });
            if (response.data.status == 'validation-error') {
                var errorArray = response.data.message;
                $.each( errorArray, function( key, errors ) {
                    $.each( errors, function( key, errorMessage ) {
                        showSznNotification({
                            type : 'error',
                            message : errorMessage
                        });
                    });
                });
            } else if (response.data.status == 'error') {
                showSznNotification({
                    type : 'error',
                    message : response.data.message
                });
            } else if (response.data.status == 'success') {
                setState({
                    ...state,
                    voted: true
                });
                showSznNotification({
                    type : 'success',
                    message : response.data.message
                });
                history.push('/lead/list')
            }
        }).catch((error) => {
            setState({
                ...state,
                loading: false
            });
            console.log(error);
        });
    }

    const showRecentLeads = () => {
        if(state.recentLeads){
            if(state.recentLeads.length > 0){
                return (
                    state.recentLeads.map((lead, i) => {
                        return <tr key={i}>
                            <td>
                                <img src="/assets/images/faces/face1.jpg" className="mr-2" alt="image"/> {lead.name} </td>
                            <td> {renderConstituency(lead.constituency_id)} </td>
                            <td> {renderParty(lead.party_id)} </td>
                            <td>
                                {authUser.email === "election@shangrila.gov.sr"?
                                <div className="progress">
                                    <div className="progress-bar bg-gradient-success" role="progressbar"
                                          style={{width: lead.votes ? lead.votes : 0 + '%'}}
                                          aria-valuenow={lead.votes ? lead.votes : 0} aria-valuemin="0"
                                          aria-valuemax="100"></div>
                                </div>:
                                    (!state?.voted && <button type="button" className="btn btn-danger btn-sm btn-upper" onClick={() => onVoteHandle(lead?.id,lead?.name)}>Vote
                            </button>)

                                }
                            </td>
                        </tr>;
                    })
                )

            }else{
                return (
                    <tr><td className="text-muted lead">No Recent Lead</td></tr>
                )
            }
        }else{
            return (
                <tr><td className="text-muted lead">No Recent Lead</td></tr>
            )
        }
    };

    const renderConstituency = (Id) => {
        switch (Id) {
            case "1":
                return "Shangri-la-Town";
            case "2":
                return "Northern-Kunlun-Mountain";
            case "3":
                return "Western-Shangri-la";
            case "4":
                return "Naboo-Vallery";
            case "5":
                return "New-Felucia";

        }
    }

    const renderParty = (Id) => {
        switch (Id) {
            case "1":
                return "Blue Party";
            case "2":
                return "Red Party";
            case "3":
                return "Yellow Party";
            case "4":
                return "Independent";

        }
    }

    return (
        <React.Fragment>
            <div className="page-header">
				<h3 className="page-title">
					<span className="page-title-icon bg-gradient-primary text-white mr-2">
						<i className="mdi mdi-home"></i>
					</span>
				 	Dashboard
				</h3>
			</div>

            {authUser.email === "election@shangrila.gov.sr" && <div className="row animated fadeIn">
                <div className="col-md-4 stretch-card grid-margin">
                    <div className="card bg-danger card-img-holder text-white">
                        <div className="card-body">
                            <img src="/assets/images/dashboard/circle.svg" className="card-img-absolute"
                                 alt="circle-image"/>
                            <h4 className="font-weight-normal mb-3">Total Leads <i
                                className="mdi mdi-chart-line mdi-24px float-right"></i>
                            </h4>
                            <h2 className="mb-5">{state.totalLeads}</h2>
                        </div>
                    </div>
                </div>
                <div className="col-md-4 stretch-card grid-margin">
                    <div className="card bg-gradient-info card-img-holder text-white">
                        <div className="card-body">
                            <img src="/assets/images/dashboard/circle.svg" className="card-img-absolute"
                                 alt="circle-image"/>
                            <h4 className="font-weight-normal mb-3">New Leads This Week <i
                                className="mdi mdi-calendar-text mdi-24px float-right"></i>
                            </h4>
                            <h2 className="mb-5">{state.weeklyLeads}</h2>
                        </div>
                    </div>
                </div>
                <div className="col-md-4 stretch-card grid-margin">
                    <div className="card bg-green-gradient card-img-holder text-white">
                        <div className="card-body">
                            <img src="/assets/images/dashboard/circle.svg" className="card-img-absolute"
                                 alt="circle-image"/>
                            <h4 className="font-weight-normal mb-3">New Leads This Month <i
                                className="mdi mdi-calendar-multiple-check mdi-24px float-right"></i>
                            </h4>
                            <h2 className="mb-5">{state.monthlyLeads}</h2>
                        </div>
                    </div>
                </div>
            </div>}
            <div className="row">
              <div className="col-12 grid-margin">
                <div className="card">
                    <div className="card-body animated fadeIn">
                        <h4 className="card-title">Recent Candidates</h4>
                        <div className="table-responsive">
                        <table className="table">
                            <thead>
                            <tr>
                                <th> Name </th>
                                <th> Constituency </th>
                                <th> Party </th>
                                <th> Votes </th>
                            </tr>
                            </thead>
                            <tbody>
                                {showRecentLeads()}
                            </tbody>
                        </table>
                        </div>
                    </div>
                </div>
              </div>
            </div>
        </React.Fragment>
    );
}


//redux state can be accessed as props in this component(Optional)
const mapStateToProps = (state) => {
	return {
		authUserProp: state.authUserReducer,
		activeComponentProp: state.activeComponentReducer,
	}
}

/**
 * redux state can be change by calling 'props.setAuthUserProp('demo user');' when
 * applicable(Optional to )
 *
 */
const mapDispatchToProps = (dispatch) => {
    return {
        setAuthUserProp: (user) => dispatch(rootAction.setAuthUser(user)),
        setActiveComponentProp: (component) => dispatch(rootAction.setActiveComponent(component))
    }
};

export default connect(mapStateToProps, mapDispatchToProps)(Dashboard)
