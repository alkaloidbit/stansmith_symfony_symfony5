import React from "react";
import { styled } from '@mui/material/styles';
import Avatar from "@mui/material/Avatar";
import Button from "@mui/material/Button";
import Card from "@mui/material/Card";
import CssBaseline from "@mui/material/CssBaseline";
import TextField from "@mui/material/TextField";
import FormControlLabel from "@mui/material/FormControlLabel";
import Checkbox from "@mui/material/Checkbox";
import Link from "@mui/material/Link";
import Grid from "@mui/material/Grid";
import Box from "@mui/material/Box";
import LockOutlinedIcon from "@mui/icons-material/LockOutlined";
import Typography from "@mui/material/Typography";
import Container from "@mui/material/Container";
import { useState } from "react";
import { useLogin, useNotify, translate, Notification } from "react-admin";

const PREFIX = 'SignIn';

const classes = {
  main: `${PREFIX}-main`,
  card: `${PREFIX}-card`,
  paper: `${PREFIX}-paper`,
  avatar: `${PREFIX}-avatar`,
  icon: `${PREFIX}-icon`,
  form: `${PREFIX}-form`,
  submit: `${PREFIX}-submit`
};

const Root = styled('div')((
  {
    theme
  }
) => ({
  [`&.${classes.main}`]: {
    display: "flex",
    flexDirection: "column",
    minHeight: "100vh",
    alignItems: "center",
    justifyContent: "flex-start",
    background: "url(https://source.unsplash.com/random/1600x900)",
    backgroundRepeat: "no-repeat",
    backgroundSize: "cover",
  },

  [`& .${classes.card}`]: {
    minWidth: 300,
    marginTop: "6em",
  },

  [`& .${classes.paper}`]: {
    marginTop: theme.spacing(8),
    display: "flex",
    flexDirection: "column",
    alignItems: "center",
  },

  [`& .${classes.avatar}`]: {
    margin: theme.spacing(1),
    display: "flex",
    justifyContent: "center",
  },

  [`& .${classes.icon}`]: {
    backgroundColor: theme.palette.secondary.main,
  },

  [`& .${classes.form}`]: {
    padding: "0 1em 1em 1em",
  },

  [`& .${classes.submit}`]: {
    margin: theme.spacing(3, 0, 2),
  }
}));

function Copyright() {
  return (
    <Typography variant="body2" color="textSecondary" align="center">
      {"Copyright © "}
      <Link color="inherit" href="https://mui.com/">
        Your Website
      </Link>{" "}
      {new Date().getFullYear()}
      {"."}
    </Typography>
  );
}

export default function SignIn() {


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
    <Root className={classes.main}>
      <Card className={classes.card}>
        <div className={classes.avatar}>
          <Avatar className={classes.icon}>
            <LockOutlinedIcon />
          </Avatar>
        </div>
        <form className={classes.form} noValidate onSubmit={handleSubmit}>
          <div className={classes.input}>
            <TextField
              margin="normal"
              required
              fullWidth
              id="email"
              label="Email Address"
              name="email"
              autoComplete="email"
              onChange={(e) => setEmail(e.target.value)}
              autoFocus
            />
          </div>
          <div className={classes.input}>
            <TextField
              margin="normal"
              required
              fullWidth
              name="password"
              label="Password"
              type="password"
              id="password"
              autoComplete="current-password"
              onChange={(e) => setPassword(e.target.value)}
            />
          </div>
          <Button
            type="submit"
            fullWidth
            variant="contained"
            color="primary"
            className={classes.submit}
          >
            Sign In
          </Button>
        </form>
      </Card>
      <Notification />
    </Root>
  );
}
