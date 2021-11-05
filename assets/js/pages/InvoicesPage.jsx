import axios from "axios";
import React, { useEffect, useState } from "react";
import Pagination from "../components/Pagination";
// import invoicesAPI from "../services/invoicesAPI";
import moment from "moment";

const STATUS_CLASSES = {
    PAID: "success",
    SENT: "info",
    CANCEL: "danger"
}

const STATUS_LABELS = {
    PAID: "Payée",
    SENT: "Envoyée",
    CANCEL: "Annulée"
}

const InvoicesPage = (props) => {

    const [invoices, setInvoices] = useState([]);

    const fetchInvoices = async () => {

        try {
            const data = await axios
                .get("http://localhost:8000/api/invoices")
                .then(response => response.data['hydra:member']);
        
            setInvoices(data)
        } catch {
            console.log(error.response);
        }       
    }

    const formatDate = (str) => moment(str).format('DD/MM/YYYY');

    useEffect(() => {
        fetchInvoices();
    }, []);

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
                {invoices.map(invoice => 
                    
                    <tr key={invoice.id}>
                        <td>{invoice.chrono}</td>
                        <td>{invoice.customer.firstName} {invoice.customer.lastName}</td>
                        <td>{formatDate(invoice.sentAt)}</td>
                        <td>
                            <span className={"btn btn-" + STATUS_CLASSES[invoice.status]}>{STATUS_LABELS[invoice.status]}</span>
                        </td>
                        <td></td>
                        <td></td>
                    </tr>
                )}
             
            </tbody>
        </table>
    </>);
    
}

export default InvoicesPage;