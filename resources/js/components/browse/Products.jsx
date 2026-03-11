import React, { useEffect, useState } from 'react';
import { Table, Button, Spinner, Alert, Badge } from 'react-bootstrap';
import axios from 'axios';

const Products = () => {
  const [products, setProducts] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);

  useEffect(() => {
    const fetchProducts = async () => {
      try {
        const response = await axios.get('/api/products');
        setProducts(response.data.data || []);
      } catch (err) {
        setError('Failed to fetch products');
        console.error('Error fetching products:', err);
      } finally {
        setLoading(false);
      }
    };

    fetchProducts();
  }, []);

  if (loading) {
    return (
      <div className="text-center my-4">
        <Spinner animation="border" role="status">
          <span className="visually-hidden">Loading...</span>
        </Spinner>
      </div>
    );
  }

  if (error) {
    return <Alert variant="danger">{error}</Alert>;
  }

  return (
    <div>
      <div className="d-flex justify-content-between align-items-center mb-4">
        <h2>Products</h2>
        <Button variant="primary">Add Product</Button>
      </div>
      
      <Table striped bordered hover>
        <thead>
          <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Description</th>
            <th>Price</th>
            <th>Category</th>
            <th>Active</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          {products.length > 0 ? (
            products.map((product) => (
              <tr key={product.id}>
                <td>{product.id}</td>
                <td>{product.name}</td>
                <td>{product.description || 'No description'}</td>
                <td>${parseFloat(product.price || 0).toFixed(2)}</td>
                <td>{product.category || 'N/A'}</td>
                <td>
                  {product.is_available ? (
                    <Badge bg="success">Available</Badge>
                  ) : (
                    <Badge bg="secondary">Unavailable</Badge>
                  )}
                </td>
                <td>
                  <Button variant="info" size="sm" className="me-2">View</Button>
                  <Button variant="warning" size="sm" className="me-2">Edit</Button>
                  <Button variant="danger" size="sm">Delete</Button>
                </td>
              </tr>
            ))
          ) : (
            <tr>
              <td colSpan="7" className="text-center">No products found</td>
            </tr>
          )}
        </tbody>
      </Table>
    </div>
  );
};

export default Products;
