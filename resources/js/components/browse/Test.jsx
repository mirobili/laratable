import React, { useState } from 'react';
import { Card, Button, Form, Row, Col, Alert, Spinner } from 'react-bootstrap';

const Test = () => {
    const [name, setName] = useState('');
    const [loading, setLoading] = useState(false);
    const [results, setResults] = useState({});

    const callApi = async (endpoint) => {
        if (!name.trim()) {
            alert('Please enter a name first');
            return;
        }

        setLoading(true);
        try {
            const response = await fetch(`/api${endpoint}/${name}`);
            const data = await response.json();
            setResults(prev => ({
                ...prev,
                [endpoint]: {
                    success: response.ok,
                    data: data,
                    timestamp: new Date().toLocaleTimeString()
                }
            }));
        } catch (error) {
            setResults(prev => ({
                ...prev,
                [endpoint]: {
                    success: false,
                    error: error.message,
                    timestamp: new Date().toLocaleTimeString()
                }
            }));
        }
        setLoading(false);
    };

    const clearResults = () => {
        setResults({});
    };

    return (
        <div>
            <div className="d-flex justify-content-between align-items-center mb-4">
                <h2>Test API Controller</h2>
                <Button variant="secondary" onClick={clearResults}>Clear Results</Button>
            </div>

            <Card className="mb-4">
                <Card.Body>
                    <Form.Group className="mb-3">
                        <Form.Label>Enter a name to test:</Form.Label>
                        <Form.Control
                            type="text"
                            value={name}
                            onChange={(e) => setName(e.target.value)}
                            placeholder="Enter your name..."
                        />
                    </Form.Group>

                    <Row>
                        <Col md={4}>
                            <Button
                                variant="primary"
                                className="w-100 mb-2"
                                onClick={() => callApi('/test/hello')}
                                disabled={loading}
                            >
                                {loading ? <Spinner size="sm" /> : 'Test Hello'}
                            </Button>
                        </Col>
                        <Col md={4}>
                            <Button
                                variant="success"
                                className="w-100 mb-2"
                                onClick={() => callApi('/test/hi')}
                                disabled={loading}
                            >
                                {loading ? <Spinner size="sm" /> : 'Test Hi'}
                            </Button>
                        </Col>
                        <Col md={4}>
                            <Button
                                variant="info"
                                className="w-100 mb-2"
                                onClick={() => callApi('/test/high')}
                                disabled={loading}
                            >
                                {loading ? <Spinner size="sm" /> : 'Test High'}
                            </Button>
                        </Col>
                    </Row>
                </Card.Body>
            </Card>

            {Object.keys(results).length > 0 && (
                <Row>
                    {Object.entries(results).map(([endpoint, result]) => (
                        <Col md={4} key={endpoint} className="mb-3">
                            <Card className={result.success ? 'border-success' : 'border-danger'}>
                                <Card.Header className={result.success ? 'bg-success text-white' : 'bg-danger text-white'}>
                                    {endpoint.replace('/test/', '').toUpperCase()}
                                    <small className="float-end">{result.timestamp}</small>
                                </Card.Header>
                                <Card.Body>
                                    {result.success ? (
                                        <div>
                                            <Alert variant="success">
                                                <strong>Message:</strong> {result.data.message}
                                            </Alert>
                                            <small className="text-muted">
                                                <strong>Greeting:</strong> {result.data.data.greeting}<br/>
                                                <strong>Name:</strong> {result.data.data.name}<br/>
                                                <strong>Success:</strong> {result.data.success ? 'Yes' : 'No'}
                                            </small>
                                        </div>
                                    ) : (
                                        <Alert variant="danger">
                                            <strong>Error:</strong> {result.error}
                                        </Alert>
                                    )}
                                </Card.Body>
                            </Card>
                        </Col>
                    ))}
                </Row>
            )}
        </div>
    );
};

export default Test;
