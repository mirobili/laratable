import React, { useEffect, useState } from 'react';
import { Table, Button, Spinner, Alert, Badge } from 'react-bootstrap';
import axios from 'axios';

const Tables = () => {
  const [tables, setTables] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);

  useEffect(() => {
    const fetchTables = async () => {
      try {
        const response = await axios.get('/api/tables');
        setTables(response.data.data || []);
      } catch (err) {
        setError('Failed to fetch tables');
        console.error('Error fetching tables:', err);
      } finally {
        setLoading(false);
      }
    };

    fetchTables();
  }, []);

  const getStatusBadge = (status) => {
    switch (status) {
      case 'available':
        return <Badge bg="success">Available</Badge>;
      case 'occupied':
        return <Badge bg="danger">Occupied</Badge>;
      case 'reserved':
        return <Badge bg="warning" text="dark">Reserved</Badge>;
      default:
        return <Badge bg="secondary">Unknown</Badge>;
    }
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
        <h2>Tables</h2>
        <Button variant="primary">Add Table</Button>
      </div>

      <Table striped bordered hover>
        <thead>
          <tr>
            <th>ID</th>
              <th>Venue ID</th>
              <th>Venue</th>
              <th>Table Number</th>
              <th>Name</th>
            <th>Capacity</th>
            <th>Status</th>
            <th>Qr Code</th>
            <th>Qr Code</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          {tables.length > 0 ? (
            tables.map((table) => {

                const baseUrl = 'http://192.168.0.114:9999/text2qr.php';

                const fileName = `qr_${table.venue.name}_${table.name}.png`;
                const encodedFileName = encodeURIComponent(fileName);

                // const qrText = `http://gitea.local:8000/order.php?vname=${encodeURIComponent(table.venue.name)}&${encodeURIComponent(table.name)}&venue=${table.venue_id}&table=${table.id}`;
                const qrText = `http://192.168.0.103:8000/new_order/?vname=${encodeURIComponent(table.venue.name)}&${encodeURIComponent(table.name)}&venue=${table.venue_id}&table=${table.id}`;
                const encodedQrText = encodeURIComponent(qrText);

                const qrCodeUrl = `${baseUrl}?file_name=${encodedFileName}&out=png&text=${encodedQrText}`;
                return (
                    <tr key={table.id}>
                        <td>{table.id}</td>
                        <td>{table.venue_id || 'N/A'} </td>
                        <td>{table.venue.name || ''}</td>
                        <td>{table.number}</td>
                        <td>{table.name || `Table ${table.id}`}</td>

                        <td>{table.capacity}</td>
                        <td>{getStatusBadge(table.status || 'available')}</td>

                        <td>
                            {table.qr_code ? (
                                <img
                                    src={`data:image/png;base64,${table.qr_code}`}
                                    alt={`QR Code for Table ${table.id}`}
                                    style={{width: '100px', height: '100px'}}
                                />
                            ) : (
                                'N/A'
                            )}
                        </td>
                        {/*<td>*/}
                        {/*    {table.qr_code ? (*/}
                        {/*        <img*/}
                        {/*            src={`http://192.168.0.114:9999/text2qr.php?file_name=${encodeURIComponent(`qr_${table.venue.name}_${table.name}.png`)}&out=png&text=${encodeURIComponent(`http://gitea.local/order.php?venue=${table.venue_id}&table=${table.id}`)}`}*/}
                        {/*            //src={`http://192.168.0.114:9999/text2qr.php?file_name=qr_${table.venue.name}_${table.name}.pngout=png&text=http%3A%2F%2Fgitea.local%2Forder.php%3Fvenue%3D${table.venue_id}%26table%3D${table.id}`}*/}
                        {/*            alt={`QR Code for Venue:${table.venue_id} Table:${table.id}`}*/}
                        {/*            style={{width: '100px', height: '100px'}}*/}
                        {/*        />*/}
                        {/*    ) : (*/}
                        {/*        'N/A'*/}
                        {/*    )}*/}
                        {/*</td>*/}
                        <td>
                            {table.qr_code ? (
                                <img
                                    src={qrCodeUrl}
                                    alt={`QR Code for Venue:${table.venue_id} Table:${table.id}`}
                                    style={{width: '100px', height: '100px'}}
                                />
                            ) : (
                                'N/A'
                            )}
                        </td>
                        <td>
                            <Button variant="info" size="sm" className="me-2">View</Button>
                            <Button variant="warning" size="sm" className="me-2">Edit</Button>
                            <Button variant="danger" size="sm">Delete</Button>
                        </td>
                    </tr>
                );
            })
          ) : (
              <tr>
                  <td colSpan="6" className="text-center">No tables found</td>
              </tr>
          )}
        </tbody>
      </Table>
    </div>
  );
};

export default Tables;
