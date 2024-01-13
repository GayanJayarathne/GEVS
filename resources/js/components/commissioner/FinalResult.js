import React, {  useState, useEffect } from 'react'
import {useSelector, connect, useDispatch} from 'react-redux';
import { fadeIn } from 'animate.css'
import 'iziToast/dist/css/iziToast.css';
import rootAction from "../../redux/actions";

const ConstituenciesResultList = (props) => {

    const [state, setState] = useState({
        authUser: props.authUserProp,
        totalSeats: null,
        loading: false,
    });

    const [partySeats,setPartySeats] = useState([])

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

        props.setActiveComponentProp('FinalResult');
        loadData();
    }, []);

    const loadData = () => {
        setState({
            ...state,
            loading: true
        });

        axios.get('/api/v1/lead/finalResults', {
            params: {
                api_token: state.authUser.api_token,
            }
        })
            .then(response => {
                setState({
                    ...state,
                    loading: false,
                    totalSeats: response.data.party_seats,
                })
                setPartySeats(renderSeats(response.data.party_seats))
            })
            .catch((error) => {
                setState({
                    ...state,
                    loading: false
                });
                console.log(error);
            });
    };

    const showRecentLeads = () => {
        if(partySeats){
            if(partySeats.length > 0){
                return (

                    partySeats && partySeats.map((lead, i) => {
                        return <tr key={i}>
                            <td>{lead.party} </td>
                            <td> {lead.seat} </td>
                        </tr>;
                    })
                )

            }else{
                return (
                    <tr><td className="text-muted lead">No Recent Result</td></tr>
                )
            }
        }else{
            return (
                <tr><td className="text-muted lead">No Recent Result</td></tr>
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

    const renderSeats = (data) => {
        if(data){
            const outputArray = [];

            for (const party in data) {
                outputArray.push({
                    "party": party,
                    "seat": String(data[party])
                });
            }

            outputArray.sort((a, b) => parseInt(b.seat) - parseInt(a.seat));

            return outputArray
        }
    }

    return (
        <React.Fragment>
                    <div className="card">
                        <div className="card-body animated fadeIn">
                            <h4 className="card-title">Final Result</h4>
                            {/*{JSON.stringify(partySeats)}*/}
                            <div className="table-responsive">
                                <table className="table">
                                    <thead>
                                    <tr>
                                        <th> Party </th>
                                        {/*<th> Votes </th>*/}
                                        <th> Seats </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    {showRecentLeads()}
                                    </tbody>
                                </table>
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

export default connect(mapStateToProps, mapDispatchToProps)(ConstituenciesResultList)
