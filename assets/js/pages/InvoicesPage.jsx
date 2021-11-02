import React, { useEffect, useState } from "react";
import Pagination from "../components/Pagination";
import invoicesAPI from "../services/invoicesAPI";

const InvoicesPage = (props) => {
    return (<>
        <h1>Invoices</h1>

        <table className="table table-hover">
            <thead>
                <tr>
                    <th>Number</th>
                    <th>Client</th>
                    <th>Date d'envoi</th>
                    <th>Status</th>
                    <th>Amount</th>
                    <th>-</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>
                        <span className="badge badge-success"></span>
                    </td>
                    <td></td>
                    <td></td>
                </tr>
            </tbody>
        </table>
    </>);
    
}

export default InvoicesPage;