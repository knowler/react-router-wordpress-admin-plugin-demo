import React, {useMemo} from 'react';
import ReactDOM from 'react-dom';
import {
  HashRouter as Router,
  Link,
  NavLink,
  Route,
  Switch,
  useLocation,
} from 'react-router-dom';
import cx from 'classnames';

import {DemoPage, OptionsPage} from './pages';

// Let’s clear the current menu content
const menuPage = document.getElementById('toplevel_page_demo');
menuPage.innerText = '';

function App() {
  const pages = usePagesWithComponents();

  return (
    <Router>
      {/* This is our portal. Here is were we override it. */}
      <Menu>
        <Link
          to="/"
          className="wp-has-submenu wp-has-current-submenu wp-menu-open menu-top menu-icon-generic toplevel_page_demo menu-top-first menu-top-last"
          aria-haspopup="false"
        >
          <div className="wp-menu-arrow">
            <div></div>
          </div>
          <div className="wp-menu-image dashicons-before dashicons-admin-generic">
            <br />
          </div>
          <div className="wp-menu-name">Demo</div>
        </Link>
        <ul className="wp-submenu wp-submenu-wrap">
          <li className="wp-submenu-head" aria-hidden="true">
            Demo
          </li>
          {pages.map(({path, title}, index) => (
            <NavItemLink
              key={path}
              to={path}
              className={cx({'wp-first-item': index === 0})}
            >
              {title}
            </NavItemLink>
          ))}
        </ul>
      </Menu>
      <Switch>
        {pages.map(({component, path, title}) => (
          <Route key={path} path={path} exact component={component} />
        ))}
      </Switch>
    </Router>
  );
}

const componentForPages = {
  '/': DemoPage,
  '/options': OptionsPage,
};

function usePagesWithComponents() {
  const pages = useMemo(
    () =>
      window.DEMO.pages.map(page => ({
        ...page,
        component: componentForPages[page.path],
      })),
    [window.DEMO.pages],
  );

  return pages;
}

function Menu({children}) {
  return ReactDOM.createPortal(children, menuPage);
}

function NavItemLink({to, className, children}) {
  const location = useLocation();

  return (
    <li className={cx(className, {current: location.pathname === to})}>
      <NavLink to={to} className={className} activeClassName="current">
        {children}
      </NavLink>
    </li>
  );
}

ReactDOM.render(<App />, document.getElementById('root'));
