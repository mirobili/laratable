import React, { useState } from 'react';
import { Container, Row, Col, Nav } from 'react-bootstrap';
import Companies from './Companies';
import Venues from './Venues';
import Tables from './Tables';
import Menus from './Menus';
import Products from './Products';
import Orders from './Orders';
import Test from './Test';

const Browse = () => {
  const [activeTab, setActiveTab] = useState('companies');

  const renderTabContent = () => {
    switch (activeTab) {
      case 'companies':
        return <Companies />;
      case 'venues':
        return <Venues />;
      case 'tables':
        return <Tables />;
      case 'menus':
        return <Menus />;
      case 'products':
        return <Products />;
      case 'orders':
        return <Orders />;
      case 'test':
        return <Test />;
      default:
        return <div>Select a resource to browse</div>;
    }
  };

  return (
    <Container fluid className="mt-4">
      <Row>
        <Col md={3}>
          <Nav className="flex-column">
            <Nav.Link active={activeTab === 'companies'} onClick={() => setActiveTab('companies')}>
              Companies
            </Nav.Link>
            <Nav.Link active={activeTab === 'venues'} onClick={() => setActiveTab('venues')}>
              Venues
            </Nav.Link>
            <Nav.Link active={activeTab === 'tables'} onClick={() => setActiveTab('tables')}>
              Tables
            </Nav.Link>
            <Nav.Link active={activeTab === 'menus'} onClick={() => setActiveTab('menus')}>
              Menus
            </Nav.Link>
            <Nav.Link active={activeTab === 'products'} onClick={() => setActiveTab('products')}>
              Products
            </Nav.Link>
            <Nav.Link active={activeTab === 'orders'} onClick={() => setActiveTab('orders')}>
              Orders
            </Nav.Link>
            <Nav.Link active={activeTab === 'test'} onClick={() => setActiveTab('test')}>
              Test API
            </Nav.Link>
          </Nav>
        </Col>
        <Col md={9}>
          {renderTabContent()}
        </Col>
      </Row>
    </Container>
  );
};

export default Browse;
