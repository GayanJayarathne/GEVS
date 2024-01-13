import React, { useState } from 'react'

const TopControlCons = (props) => {

    return (
        <React.Fragment>
            <div className="pt-3 pb-3">
                <div className="d-flex flex-column flex-md-row justify-content-md-between">
                    <div className="d-flex flex-row">
                        <div className="p-2">
                            <div className="input-group input-group-sm">
                                <div className="input-group-prepend">
                                    <span className="input-group-text">Display</span>
                                </div>
                                <select className="form-control form-control-sm" placeholder="Constituency" id="constituency" name="constituency" value={props?.cons} onChange={props.onChangeConstituencyHandle}>
                                    <option value="1">Shangri-la-Town</option>
                                    <option value="2">Northern-Kunlun-Mountain</option>
                                    <option value="3">Western-Shangri-la</option>
                                    <option value="4">Naboo-Vallery</option>
                                    <option value="5">New-Felucia</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </React.Fragment>
    );
}

export default TopControlCons
