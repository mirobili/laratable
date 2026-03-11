import React from 'react';
import { Container, Navbar, Nav, Button } from 'react-bootstrap';
import { Routes, Route, Link, useLocation } from 'react-router-dom';
import Browse from './browse/Browse';

function App() {
  const location = useLocation();
  const isBrowseRoute = location.pathname.startsWith('/browse');

  return (
    <div className="app">
      <Navbar bg="dark" variant="dark" expand="lg" className="mb-4">
        <Container>
          <Navbar.Brand as={Link} to="/">Table Manager</Navbar.Brand>
          <Navbar.Toggle aria-controls="basic-navbar-nav" />
          <Navbar.Collapse id="basic-navbar-nav">
            <Nav className="me-auto">
              <Nav.Link as={Link} to="/" className={!isBrowseRoute ? 'active' : ''}>
                Home
              </Nav.Link>
              <Nav.Link as={Link} to="/browse" className={isBrowseRoute ? 'active' : ''}>
                Browse
              </Nav.Link>
            </Nav>
          </Navbar.Collapse>
        </Container>
      </Navbar>

      <Container fluid className="py-4">
        <Routes>
          <Route path="/" element={
            <div className="text-center py-5">
              <h1>Welcome to Table Manager</h1>
              <p className="lead">Manage your restaurants, menus, tables, and orders in one place.</p>
              <div className="mt-4">
                <Button as={Link} to="/browse" variant="primary" size="lg" className="me-3">
                  Get Started
                </Button>
                <Button variant="outline-secondary" size="lg">
                  Learn More
                </Button>
              </div>
            </div>
          } />
          <Route path="/browse/*" element={<Browse />} />
        </Routes>
      </Container>
    </div>
  );
}

export default App;
