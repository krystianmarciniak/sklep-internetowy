import React, { useEffect, useState } from 'react';
import axios from 'axios';
import './styles.css';

function ProductList() {
  const [products, setProducts] = useState([]);
  const [editingId, setEditingId] = useState(null);
  const [editForm, setEditForm] = useState({});

  const API_URL = "http://localhost:8000/api/products";

  useEffect(() => {
    fetchProducts();
  }, []);

  const fetchProducts = () => {
    axios.get(API_URL)
      .then(res => setProducts(res.data))
      .catch(err => console.error(err));
  };

  const startEdit = (product) => {
    setEditingId(product.produkt_id);
    setEditForm(product);
  };

  const cancelEdit = () => {
    setEditingId(null);
    setEditForm({});
  };

  const handleChange = (e) => {
    setEditForm({
      ...editForm,
      [e.target.name]: e.target.value
    });
  };

  const saveEdit = () => {
    axios.put(`${API_URL}/${editingId}`, editForm)
      .then(() => {
        fetchProducts();
        cancelEdit();
      })
      .catch(err => console.error(err));
  };

  const deleteProduct = (id) => {
    axios.delete(`${API_URL}/${id}`)
      .then(() => fetchProducts())
      .catch(err => console.error(err));
  };

  return (
    <div className="container">
      <h2>Lista Produktów</h2>
      <table>
        <thead>
          <tr>
            <th>ID</th>
            <th>Nazwa</th>
            <th>Parametr</th>
            <th>Cena</th>
            <th>Kategoria</th>
            <th>Akcje</th>
          </tr>
        </thead>
        <tbody>
          {products.map(product => (
            <tr key={product.produkt_id}>
              <td>{product.produkt_id}</td>
              {editingId === product.produkt_id ? (
                <>
                  <td><input name="nazwa" value={editForm.nazwa} onChange={handleChange} /></td>
                  <td><input name="parametr" value={editForm.parametr} onChange={handleChange} /></td>
                  <td><input name="cena_brutto" value={editForm.cena_brutto} onChange={handleChange} /></td>
                  <td><input name="id_kategoria" value={editForm.id_kategoria} onChange={handleChange} /></td>
                  <td>
                    <button className="btn-save" onClick={saveEdit}>Zapisz</button>
                    <button className="btn-cancel" onClick={cancelEdit}>Anuluj</button>
                  </td>
                </>
              ) : (
                <>
                  <td>{product.nazwa}</td>
                  <td>{product.parametr}</td>
                  <td>{product.cena_brutto} zł</td>
                  <td>{product.id_kategoria}</td>
                  <td>
                    <button className="btn-edit" onClick={() => startEdit(product)}>Edytuj</button>
                    <button className="btn-delete" onClick={() => deleteProduct(product.produkt_id)}>Usuń</button>
                  </td>
                </>
              )}
            </tr>
          ))}
        </tbody>
      </table>
    </div>
  );
}

export default ProductList;
