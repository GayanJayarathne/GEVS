import React, { Component } from 'react'
import moment from 'moment';
import { Link } from 'react-router-dom';

const LeadItem =(props)=> {
    // constructor(props) {
    //     super(props);
    //     this.state = {
    //
    //     }
    //
    // }
    //
    // componentDidMount() {
    //
    // }

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

    const renderPartyColor = (Id) => {
        switch (Id) {
            case "1":
                return "Blue";
            case "2":
                return "Red";
            case "3":
                return "Yellow";
            case "4":
                return "Green";

        }
    }

    // render() {
        return (
            <React.Fragment>
                <div className="szn-portlet">
                    <div className="szn-portlet__body">
                        <div className="szn-widget szn-widget--user-profile-3">
                            <div className="szn-widget__top">
                                { true ?
                                <div className="szn-widget__media szn-hidden-">
                                    <img src="/assets/images/faces/face1.jpg" alt="image" />
                                </div> :
                                <div
                                    className="szn-widget__pic szn-widget__pic--danger szn-font-danger szn-font-boldest szn-font-light ">
                                    {props.obj.name.split(' ').map(function(str) { return str ? str[0].toUpperCase() : "";}).join('')}
                                </div> }
                                <div className="szn-widget__content">
                                    <div className="szn-widget__head">
                                        <Link to={{
                                            pathname: `/lead/edit/${props.obj.id}`,
                                            state: {
                                                lead: props.obj
                                            }
                                        }} className="szn-widget__username">
                                            {props.obj.name}
                                            { props.obj.status == 0 ? <i className="mdi mdi-close-circle-outline szn-font-danger"></i>
                                            : <i className="mdi mdi-checkbox-marked-circle szn-font-success"></i> }
                                        </Link>
                                        <div className="szn-widget__action">
                                            <Link to={{
                                                pathname: `/lead/edit/${props.obj.id}`,
                                                state: {
                                                    lead: props.obj
                                                }
                                            }} type="button" className="btn btn-outline-success btn-sm btn-upper">Edit</Link>&nbsp;
                                            {/*<button type="button" className="btn btn-danger btn-sm btn-upper" onClick={() => props.onClickDeleteHandler(props.obj.id)}>Delete</button>*/}
                                        </div>
                                    </div>
                                    <div className="szn-widget__subhead d-flex flex-column flex-md-row">
                                        <a href={void(0)}><i className="mdi mdi-map-marker"></i>{renderConstituency(props.obj.constituency_id)}</a>
                                        <a href={void(0)}><i className="mdi mdi-flag" style={{color:renderPartyColor(props.obj.party_id)}}></i>{renderParty(props.obj.party_id)} </a>
                                    </div>
                                    {/*<div className="szn-widget__info">*/}
                                    {/*    <div className="szn-widget__progress">*/}
                                    {/*        <div className="szn-widget__text">*/}
                                    {/*            Progress*/}
                                    {/*        </div>*/}
                                    {/*        <div className="progress" style={{ height: '5px', width: '100%' }}>*/}
                                    {/*            <div className="progress-bar szn-bg-success" role="progressbar" style={{ width: props.obj.progress+'%' }}*/}
                                    {/*                aria-valuenow={props.obj.progress} aria-valuemin="0" aria-valuemax="100"></div>*/}
                                    {/*        </div>*/}
                                    {/*        <div className="szn-widget__stats">*/}
                                    {/*            {props.obj.progress}%*/}
                                    {/*        </div>*/}
                                    {/*    </div>*/}
                                    {/*</div>*/}
                                </div>
                            </div>
                            <div className="szn-widget__bottom d-flex flex-column flex-md-row">
                                <div className="szn-widget__item ">
                                    <div className="szn-widget__icon">
                                        <i className="mdi mdi-close-box"></i>
                                    </div>
                                    <div className="szn-widget__details d-flex flex-md-column flex-row">
                                        <span className="szn-widget__title">Votes</span>
                                        <span className="szn-widget__value">{props.obj.votes}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </React.Fragment>
        )
    // }
}

export default LeadItem
