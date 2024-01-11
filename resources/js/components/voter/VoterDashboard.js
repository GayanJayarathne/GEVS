import React, {  useState, useEffect } from 'react'
import Pagination from "react-js-pagination";
import { useSelector, connect } from 'react-redux';
import rootAction from '../redux/actions/index'
import { fadeIn } from 'animate.css'
import 'iziToast/dist/css/iziToast.css';

const VoterDashboard = (props) => {

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
        loadData();
    }, []);

    const loadData = () => {
        setState({
            ...state,
            loading: true
        });
        axios.get('/api/v1/candidate/constituency-list', {
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

    const onVoteHandle = (Id) => {

    }

    const showRecentLeads = () => {
        return state.recentLeads.length == 0 ? <tr><td className="text-muted lead">No Recent Lead</td></tr> :
                state.recentLeads.map((lead, i) => {
                    return <tr key={i}>
                                <td>
                                    <img src="/assets/images/faces/face1.jpg" className="mr-2" alt="image"/> {lead.name} </td>
                                <td> {renderConstituency(lead.constituency_id)} </td>
                                <td> {renderParty(lead.party_id)} </td>
                                <td>
                                    <div className="progress">
                                        <button type="button" className="btn btn-danger btn-sm btn-upper" onClick={() => onVoteHandle(lead?.id)}>Vote</button>
                                    </div>
                                </td>
                            </tr>;
                });
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

export default connect(mapStateToProps, mapDispatchToProps)(VoterDashboard)
