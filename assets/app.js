// Les imports importants

import React from "react";
import ReactDOM from "react-dom";
import Navbar from "./js/components/Navbar";
import HomePage from "./js/pages/HomePage";
import CustomersPage from "./js/pages/CustomersPage";
// import CustomerPageWithPaginate from "./js/pages/CustomerPageWithPaginate";
import { HashRouter, Switch, Route } from "react-router-dom";


/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.css';

// start the Stimulus application
import './bootstrap';

const App = () => {
    return <HashRouter>
        <Navbar />

        <main className="container pt-4">
            <Switch>
                <Route path="/customers" component={CustomersPage}></Route> 
                {/* <Route path="/customers" component={CustomerPageWithPaginate}></Route>  */}
                <Route path="/" component={HomePage}></Route> 
            </Switch>
        </main>
    </HashRouter>  
};

const rootElement  = document.querySelector('#app');
ReactDOM.render(<App />, rootElement);


