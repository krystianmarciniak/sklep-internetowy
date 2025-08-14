import React, { useState, useEffect } from 'react';
import axios from 'axios';
import './styles.css';

function OrderItemsList() {
  const [orders, setOrders] = useState([]);
  const [message, setMessage] = useState({ type: '', text: '' });

  const [newOrder, setNewOrder] = useState({
    klient_id: '',
    produkt_id: '',
    ilosc: 1,
  });

  const API_URL = 'http://localhost:8000/api/order-items';

  // Pobierz listę zamówień
  useEffect(() => {
    fetchOrders();
  }, []);

  const fetchOrders = async () => {
    try {
      const res = await axios.get(API_URL);
      setOrders(res.data);
    } catch (err) {
      console.error('Błąd podczas pobierania zamówień:', err);
    }
  };

  // Obsługa formularza
  const handleChange = (e) => {
    setNewOrder({
      ...newOrder,
      [e.target.name]: e.target.value,
    });
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
    try {
      await axios.post(API_URL, newOrder);
      // wyczyszczenie formularza
      setNewOrder({ klient_id: '', produkt_id: '', ilosc: 1 });
      // komunikat sukcesu
      setMessage({ type: 'success', text: 'Zamówienie zostało złożone!' });
      fetchOrders();
    } catch (err) {
      console.error(err);
      // komunikat błędu
      setMessage({ type: 'error', text: 'Wystąpił błąd. Spróbuj ponownie.' });
    }
    // po 3 sekundach komunikat znika
    setTimeout(() => setMessage({ type: '', text: '' }), 3000);
  };

  return (
    <div className="order-container">
      <h2>Nowe Zamówienie</h2>
      <form onSubmit={handleSubmit} className="order-form">
        <input
          type="text"
          name="klient_id"
          placeholder="ID Klienta"
          value={newOrder.klient_id}
          onChange={handleChange}
          required
        />
        <input
          type="text"
          name="produkt_id"
          placeholder="ID Produktu"
          value={newOrder.produkt_id}
          onChange={handleChange}
          required
        />
        <input
          type="number"
          name="ilosc"
          min="1"
          placeholder="Ilość"
          value={newOrder.ilosc}
          onChange={handleChange}
          required
        />
        <button type="submit" className="btn btn-primary">
          Złóż zamówienie
        </button>
      </form>

      {/* tutaj alert */}
      {message.text && (
        <div className={`alert ${message.type}`}>
          {message.text}
        </div>
      )}

      <h2>Lista Zamówień</h2>
      <table className="table">
        <thead>
          <tr>
            <th>ID Zamówienia</th>
            <th>Klient ID</th>
            <th>Produkt ID</th>
            <th>Ilość</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          {orders.map((order) => (
            <tr key={order.zamowienie_id}>
              <td>{order.zamowienie_id}</td>
              <td>{order.klient_id}</td>
              <td>{order.produkt_id}</td>
              <td>{order.ilosc}</td>
              <td>{order.status}</td>
            </tr>
          ))}
        </tbody>
      </table>
    </div>
  );
}

export default OrderItemsList;
