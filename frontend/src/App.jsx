import React from 'react';
import { BrowserRouter as Router, Routes, Route, Link } from 'react-router-dom';
import ProductList from './ProductList';
import OrderItemsList from './OrderItemsList';

import CustomersList from './CustomersList';
import './styles.css';

function App() {
  return (
    <Router>
      <div className="App">
        <h1>Sklep Internetowy - Frontend</h1>
        <nav>
          <Link to="/products" className="nav-link">Produkty</Link>
          <Link to="/orders" className="nav-link">Zamówienia</Link>
          <Link to="/customers" className="nav-link">Klienci</Link>
        </nav>
        <Routes>
          <Route path="/" element={<ProductList />} />
          <Route path="/products" element={<ProductList />} />
          <Route path="/orders" element={<OrderItemsList />} />
          <Route path="/customers" element={<CustomersList />} />
        </Routes>
      </div>
    </Router>
  );
}

export default App;
