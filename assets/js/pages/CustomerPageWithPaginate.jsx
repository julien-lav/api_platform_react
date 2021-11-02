import React, {useEffect, useState} from "react";
import axios from "axios";
import Pagination from "../components/Pagination";

const CustomerPageWithPaginate = props => {

    const [customers, setCustomers ] = useState([]);
    const [totalItems, SetTotalItems] = useState(0);
    const [currentPage, setCurrentPage] = useState(1);
    const [loading, setLoading] = useState(true);
    const itemsPerPage = 10;
       
    useEffect(() => {
        axios
            .get(
                `http://localhost:8000/api/customers?pagination=true&count=${itemsPerPage}&page=${currentPage}`
                )
            .then(response => {
                setCustomers(response.data["hydra:member"]);
                SetTotalItems(response.data["hydra:totalItems"]);
                setLoading(false);
            })
            .catch(error => console.log(error.response));
    }, [currentPage])

    const handleDelete = id  => {        
        setCustomers(customers.filter(customer => customer.id !== id));
        const originalCustomers = [...customers];
        axios
            .delete("http://localhost:8000/api/customers" + id) 
            .then(response => console.log(response))
            .catch(error => {
                setCustomers(originalCustomers);
            });
    };
    
    /* Pagination handler */
    const handlePageChange = (page) => {
        setCurrentPage(page);
    }
    const paginatedCustomers = Pagination.getData(customers, currentPage, itemsPerPage);
    return <>
    <h1>Liste des clients (Pagination)</h1>
    <table className="table table-hover">
        <thead>
            <tr>
                <th>Id.</th>
                <th>Client</th>
                <th>Email</th>
                <th>Entreprise</th>
                <th>Factures</th>
                <th>Montant total</th>  
            </tr>
        </thead>
        <tbody>
        {loading && (
            <tr>
              <td>Chargement ...</td>
            </tr>
          )}
          {!loading &&
            customers.map(customer => (
                <tr key={customer.id}>
                    <td>{customer.id}</td>
                    <td>{customer.firstname} {customer.lastname}</td>
                    <td>{customer.email}</td>
                    <td>{customer.company}</td>
                    <td className="text-center "><span>{customer.invoices.length}</span></td>
                    <td className="text-center">{customer.totalAmount} €</td>
                    {/* <td className="text-center">{customer.totalAmount.toLocaleString()} €</td> */}
                    <td className="text-center">
                        <button 
                            onClick={() => handleDelete(customer.id)}
                            // disabled={customer.invoices.length > 0} 
                            className="btn btn-danger">Supprimer
                        </button>
                    </td>
                </tr>
                ))}
        </tbody>
    </table>

    <Pagination currentPage={currentPage} itemsPerPage={itemsPerPage} length={totalItems} onPageChanged={handlePageChange} />

    </>
};

export default CustomerPageWithPaginate;