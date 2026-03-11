import React, { useEffect, useState } from 'react';
import { Table, Button, Spinner, Alert } from 'react-bootstrap';
import axios from 'axios';

const Venues = () => {
  const [venues, setVenues] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);

  useEffect(() => {
    const fetchVenues = async () => {
      try {
        const response = await axios.get('/api/venues');
        setVenues(response.data.data || []);
      } catch (err) {
        setError('Failed to fetch venues');
        console.error('Error fetching venues:', err);
      } finally {
        setLoading(false);
      }
    };

    fetchVenues();
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
        <h2>Venues</h2>
        <Button variant="primary">Add Venue</Button>
      </div>
      
      <Table striped bordered hover>
        <thead>
          <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Address</th>
            <th>Phone</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          {venues.length > 0 ? (
            venues.map((venue) => (
              <tr key={venue.id}>
                <td>{venue.id}</td>
                <td>{venue.name}</td>
                <td>{venue.address}</td>
                <td>{venue.phone}</td>
                <td>
                  <Button variant="info" size="sm" className="me-2">View</Button>
                  <Button variant="warning" size="sm" className="me-2">Edit</Button>
                  <Button variant="danger" size="sm">Delete</Button>
                </td>
              </tr>
            ))
          ) : (
            <tr>
              <td colSpan="5" className="text-center">No venues found</td>
            </tr>
          )}
        </tbody>
      </Table>
    </div>
  );
};

export default Venues;
