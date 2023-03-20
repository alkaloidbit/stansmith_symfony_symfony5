// in src/MyLoginPage.js
import React, { Component } from "react";
import { useState } from "react";
import { useLogin, useNotify, Notification } from "react-admin";
import compose from "recompose/compose";

import Avatar from "@material-ui/core/Avatar";
import Button from "@material-ui/core/Button";
import Card from "@material-ui/core/Card";
import CardActions from "@material-ui/core/CardActions";
import CircularProgress from "@material-ui/core/CircularProgress";
import TextField from "@material-ui/core/TextField";
import { withStyles } from "@material-ui/core/styles";
import LockIcon from "@material-ui/icons/Lock";
import { MenuItem, Select, FormControl, InputLabel } from "@material-ui/core";

const styles = (theme) => ({
  main: {
    display: "flex",
    flexDirection: "column",
    minHeight: "100vh",
    alignItems: "center",
    justifyContent: "flex-start",
    background: "url(https://source.unsplash.com/random/1600x900)",
    backgroundRepeat: "no-repeat",
    backgroundSize: "cover",
  },
  card: {
    minWidth: 300,
    marginTop: "6em",
  },
  avatar: {
    margin: "1em",
    display: "flex",
    justifyContent: "center",
  },
  icon: {
    backgroundColor: theme.palette.secondary.main,
  },
  hint: {
    marginTop: "1em",
    display: "flex",
    justifyContent: "center",
    color: theme.palette.grey[500],
  },
  form: {
    padding: "0 1em 1em 1em",
  },
  input: {
    marginTop: "1em",
  },
  actions: {
    padding: "0 1em 1em 1em",
  },
});

class Login extends Component {
  render() {
    const { classes } = this.props;
    return (
      <div className={classes.main}>
        <Card className={classes.card}>
          <div className={classes.avatar}>
            <Avatar className={classes.icon}>
              <LockIcon />
            </Avatar>
          </div>
          <form>
            <input
              name="email"
              type="email"
              onChange={(e) => setEmail(e.target.value)}
            />
            <input
              name="password"
              type="password"
              onChange={(e) => setPassword(e.target.value)}
            />
            <input type="submit" value="Ok" />
          </form>
        </Card>
        <Notification />
      </div>
    );
  }
}

const MyLoginPage = ({ theme }) => {
  const [email, setEmail] = useState("");
  const [password, setPassword] = useState("");
  const login = useLogin();
  const notify = useNotify();

  const handleSubmit = (e) => {
    e.preventDefault();
    // will call authProvider.login({ email, password })
    login({ email, password }).catch(() => notify("Invalid email or password"));
  };

  return (
    <div>
      <Card>
        <form onSubmit={handleSubmit}>
          <input
            name="email"
            type="email"
            value={email}
            onChange={(e) => setEmail(e.target.value)}
          />
          <input
            name="password"
            type="password"
            value={password}
            onChange={(e) => setPassword(e.target.value)}
          />
          <input type="submit" value="Ok" />
        </form>
      </Card>
      <Notification />
    </div>
  );
};

const enhance = compose(withStyles(styles));

export default enhance(MyLoginPage);
