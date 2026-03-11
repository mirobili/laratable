import React, { useEffect, useState } from 'react';
import { Table, Button, Spinner, Alert, Badge } from 'react-bootstrap';
import axios from 'axios';

const Menus = () => {
  const [menus, setMenus] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);

  useEffect(() => {
    const fetchMenus = async () => {
      try {
        const response = await axios.get('/api/menus');
        setMenus(response.data.data || []);
      } catch (err) {
        setError('Failed to fetch menus');
        console.error('Error fetching menus:', err);
      } finally {
        setLoading(false);
      }
    };

    fetchMenus();
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
        <h2>Menus</h2>
        <Button variant="primary">Add Menu</Button>
      </div>
      
      <Table striped bordered hover>
        <thead>
          <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Description</th>
            <th>Active</th>
            <th>Sections</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          {menus.length > 0 ? (
            menus.map((menu) => (
              <tr key={menu.id}>
                <td>{menu.id}</td>
                <td>{menu.name}</td>
                <td>{menu.description || 'No description'}</td>
                <td>
                  {menu.is_active ? (
                    <Badge bg="success">Active</Badge>
                  ) : (
                    <Badge bg="secondary">Inactive</Badge>
                  )}
                </td>
                <td>{menu.sections_count || 0}</td>
                <td>
                  <Button variant="info" size="sm" className="me-2">View</Button>
                  <Button variant="warning" size="sm" className="me-2">Edit</Button>
                  <Button variant="danger" size="sm">Delete</Button>
                </td>
              </tr>
            ))
          ) : (
            <tr>
              <td colSpan="6" className="text-center">No menus found</td>
            </tr>
          )}
        </tbody>
      </Table>
    </div>
  );
};

export default Menus;
