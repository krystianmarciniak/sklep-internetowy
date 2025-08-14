import React, { useState, useEffect } from 'react';
import axios from 'axios';

const CustomersList = () => {
    const [customers, setCustomers] = useState([]);
    const [form, setForm] = useState({
        imie: '', nazwisko: '', miasto: '', ulica: '', email: ''
    });
    const [alert, setAlert] = useState('');

    const fetchCustomers = async () => {
        const response = await axios.get('http://localhost:8000/api/customers');
        setCustomers(response.data);
    };

    useEffect(() => {
        fetchCustomers();
    }, []);

    const handleChange = (e) => {
        setForm({ ...form, [e.target.name]: e.target.value });
    };

    const handleSubmit = async (e) => {
        e.preventDefault();
        try {
            await axios.post('http://localhost:8000/api/customers', form);
            setAlert('Dodano klienta');
            setForm({ imie: '', nazwisko: '', miasto: '', ulica: '', email: '' });
            fetchCustomers();
        } catch (err) {
            setAlert('Błąd przy dodawaniu');
        }
    };

    const handleDelete = async (id) => {
        if (window.confirm("Na pewno usunąć klienta?")) {
            await axios.delete(`http://localhost:8000/api/customers/${id}`);
            fetchCustomers();
        }
    };

    return (
        <div className="App">
            <h1>Sklep Internetowy - Klienci</h1>

            <form onSubmit={handleSubmit} className="order-form">
                <input name="imie" value={form.imie} onChange={handleChange} placeholder="Imię" />
                <input name="nazwisko" value={form.nazwisko} onChange={handleChange} placeholder="Nazwisko" />
                <input name="miasto" value={form.miasto} onChange={handleChange} placeholder="Miasto" />
                <input name="ulica" value={form.ulica} onChange={handleChange} placeholder="Ulica" />
                <input name="email" value={form.email} onChange={handleChange} placeholder="Email" />
                <button type="submit" className="btn btn-primary">Dodaj klienta</button>
            </form>

            {alert && <div className="alert success">{alert}</div>}

            <table className="table">
                <thead>
                    <tr>
                        <th>ID</th><th>Imię</th><th>Nazwisko</th><th>Miasto</th><th>Ulica</th><th>Email</th><th>Akcje</th>
                    </tr>
                </thead>
                <tbody>
                    {customers.map(customer => (
                        <tr key={customer.klient_id}>
                            <td>{customer.klient_id}</td>
                            <td>{customer.imie}</td>
                            <td>{customer.nazwisko}</td>
                            <td>{customer.miasto}</td>
                            <td>{customer.ulica}</td>
                            <td>{customer.email}</td>
                            <td>
                                <button className="delete" onClick={() => handleDelete(customer.klient_id)}>Usuń</button>
                            </td>
                        </tr>
                    ))}
                </tbody>
            </table>
        </div>
    );
};

export default CustomersList;
