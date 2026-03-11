import React, { useEffect, useState } from 'react';
import { Table, Button, Spinner, Alert, Badge } from 'react-bootstrap';
import axios from 'axios';

const Orders = () => {
  const [orders, setOrders] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);

  useEffect(() => {
    const fetchOrders = async () => {
      try {
        const response = await axios.get('/api/orders');
        setOrders(response.data.data || []);
      } catch (err) {
        setError('Failed to fetch orders');
        console.error('Error fetching orders:', err);
      } finally {
        setLoading(false);
      }
    };

    fetchOrders();
  }, []);

  const getStatusBadge = (status) => {
    switch (status) {
      case 'pending':
        return <Badge bg="warning" text="dark">Pending</Badge>;
      case 'completed':
        return <Badge bg="success">Completed</Badge>;
      case 'cancelled':
        return <Badge bg="danger">Cancelled</Badge>;
      case 'in_progress':
        return <Badge bg="info">In Progress</Badge>;
      default:
        return <Badge bg="secondary">Unknown</Badge>;
    }
  };

  const formatDate = (dateString) => {
    if (!dateString) return 'N/A';
    return new Date(dateString).toLocaleString();
  };

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
        <h2>Orders</h2>
        <Button variant="primary">Create Order</Button>
      </div>
      
      <Table striped bordered hover>
        <thead>
          <tr>
            <th>Order #</th>
            <th>Table</th>
            <th>Status</th>
            <th>Total</th>
            <th>Items</th>
            <th>Created At</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          {orders.length > 0 ? (
            orders.map((order) => (
              <tr key={order.id}>
                <td>#{order.id.toString().padStart(4, '0')}</td>
                <td>{order.table?.name || 'N/A'}</td>
                <td>{getStatusBadge(order.status)}</td>
                <td>${parseFloat(order.total || 0).toFixed(2)}</td>
                <td>{order.items_count || 0}</td>
                <td>{formatDate(order.created_at)}</td>
                <td>
                  <Button variant="info" size="sm" className="me-2">View</Button>
                  <Button variant="warning" size="sm" className="me-2">Edit</Button>
                  <Button variant="danger" size="sm">Cancel</Button>
                </td>
              </tr>
            ))
          ) : (
            <tr>
              <td colSpan="7" className="text-center">No orders found</td>
            </tr>
          )}
        </tbody>
      </Table>
    </div>
  );
};

export default Orders;
