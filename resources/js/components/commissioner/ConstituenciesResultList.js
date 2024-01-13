import React, {  useState, useEffect } from 'react'
import {useSelector, connect, useDispatch} from 'react-redux';
import { fadeIn } from 'animate.css'
import 'iziToast/dist/css/iziToast.css';
import rootAction from "../../redux/actions";

const ConstituenciesResultList = (props) => {

    const [state, setState] = useState({
        authUser: props.authUserProp,
        consResult: [],
        loading: false,
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

        props.setActiveComponentProp('ConstituenciesResultList');
        loadData();
    }, []);

    const loadData = () => {
        setState({
            ...state,
            loading: true
        });
        axios.get('/api/v1/constituency/results', {
            params: {
                api_token: state.authUser.api_token,
            }
        })
            .then(response => {
                setState({
                    ...state,
                    loading: false,
                    consResult: response.data.result,
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

    const showRecentLeads = (data) => {
        if(data){
            if(data.length > 0){
                return (
                    data.map((lead, i) => {
                        return <tr key={i}>
                            <td>
                                <img src="/assets/images/faces/face1.jpg" className="mr-2" alt="image"/> {lead.candidate_name
                            } </td>
                            <td> {lead.party_name} </td>
                            <td>
                                    {/*<div className="progress">*/}
                                    {/*    <div className="progress-bar bg-gradient-success" role="progressbar"*/}
                                    {/*         style={{width: lead.votes ? lead.votes : 0 + '%'}}*/}
                                    {/*         aria-valuenow={lead.votes ? lead.votes : 0} aria-valuemin="0"*/}
                                    {/*         aria-valuemax="100"></div>*/}
                                    {/*</div>*/}
                                {lead.votes}
                            </td>
                        </tr>;
                    })
                )

            }else{
                return (
                    <tr><td className="text-muted lead">No Result</td></tr>
                )
            }
        }else{
            return (
                <tr><td className="text-muted lead">No Result</td></tr>
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

    let constituencyList = [
        'constituency1',
        'constituency2',
        'constituency3',
        'constituency4',
        'constituency5',
    ]




    const renderTable = (item,title) => {

            return (
                <>
                    <h4 className="card-title">{title}</h4>
                    <div className="table-responsive">
                        <table className="table">
                            <thead>
                            <tr>
                                <th> Name </th>
                                <th> Party </th>
                                <th> Votes </th>
                            </tr>
                            </thead>
                            <tbody>
                            {showRecentLeads(item?.data)}
                            </tbody>
                        </table>
                    </div>
                </>
            )
    }

    return (
        <React.Fragment>
                    <div className="card">
                        <div className="card-body animated fadeIn">
                            {renderTable(state.consResult.constituency1,"Shangri-la-Town")}
                            {renderTable(state.consResult.constituency2,"Northern-Kunlun-Mountain")}
                            {renderTable(state.consResult.constituency3,"Western-Shangri-la")}
                            {renderTable(state.consResult.constituency4,"Naboo-Vallery")}
                            {renderTable(state.consResult.constituency5,"New-Felucia")}
                            {/*<h4 className="card-title">{"item"}</h4>*/}
                            {/*<div className="table-responsive">*/}
                            {/*    <table className="table">*/}
                            {/*        <thead>*/}
                            {/*        <tr>*/}
                            {/*            <th> Name </th>*/}
                            {/*            <th> Party </th>*/}
                            {/*            <th> Votes </th>*/}
                            {/*        </tr>*/}
                            {/*        </thead>*/}
                            {/*        <tbody>*/}
                            {/*        {showRecentLeads(result?.data)}*/}
                            {/*        </tbody>*/}
                            {/*    </table>*/}
                            {/*</div>*/}
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
