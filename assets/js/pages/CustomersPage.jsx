import React, {useEffect, useState} from "react";
import axios from "axios";
import Pagination from "../components/Pagination";

const CustomersPage = props => {

    const [customers, setCustomers ] = useState([]);
    const [currentPage, setCurrentPage] = useState(1);
    const [search, setSearch] = useState("");


    const handleDelete = id  => {        
        setCustomers(customers.filter(customer => customer.id !== id));
        const originalCustomers = [...customers];
        axios
            .delete("http://://localhost:8000/api/customers" + id) 
            .then(response => console.log(response))
            .catch(error => {
                setCustomers(originalCustomers);
                console.log(error.response)
            });
    };
    

    const handleSearch = (event) => {
        const value = event.currentTarget.value;
        setSearch(value);
        setCurrentPage(1);
    };

    const filteredCustomers = customers.filter(
        c => 
            c.firstname.toLowerCase().includes(search.toLowerCase()) ||
            c.lastname.toLowerCase().includes(search.toLowerCase()) ||
            c.email.toLowerCase().includes(search.toLowerCase()) ||
            (c.company && c.company.toLowerCase().includes(search.toLowerCase())) 
    );

    /* Pagination handler */
    const handlePageChange = (page) => {
        setCurrentPage(page);
    }
    const itemsPerPage = 10;
    const paginatedCustomers = Pagination.getData(filteredCustomers, currentPage, itemsPerPage);
    
    
    useEffect(() => {
        axios
            .get("http://localhost:8000/api/customers")
            .then(response => response.data["hydra:member"])
            .then(data => setCustomers(data))
            .catch(error => console.log(error.response));
    }, []);

    return <>
    <h1>Liste des clients</h1>

    <div className="form-group">
        <input type="text" onChange={handleSearch} value={search} className="form-control" placeholder="Rechercher"/>
    </div>
    
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
            {paginatedCustomers.map(customer => 
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
                )}
        
        </tbody>
    </table>
    
    {itemsPerPage < filteredCustomers.length && 
        <Pagination currentPage={currentPage} itemsPerPage={itemsPerPage} length={filteredCustomers.length} onPageChanged={handlePageChange} />
    }
    </>
};

export default CustomersPage;