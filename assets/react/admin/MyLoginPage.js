// in src/MyLoginPage.js
import * as React from "react";
import { styled } from '@mui/material/styles';
import { useState } from "react";
import { useLogin, useNotify, translate, Notification } from "react-admin";
import Avatar from "@mui/material/Avatar";
import Button from '@mui/material/Button';
import Card from "@mui/material/Card";
import CardActions from '@mui/material/CardActions';
import CircularProgress from '@mui/material/CircularProgress';
import TextField from '@mui/material/TextField';
import LockIcon from '@mui/icons-material/Lock';
import { MenuItem, Select, FormControl, InputLabel } from '@mui/material';
const PREFIX = 'MyLoginPage';

const classes = {
    main: `${PREFIX}-main`,
    card: `${PREFIX}-card`,
    avatar: `${PREFIX}-avatar`,
    icon: `${PREFIX}-icon`,
    hint: `${PREFIX}-hint`,
    form: `${PREFIX}-form`,
    input: `${PREFIX}-input`,
    actions: `${PREFIX}-actions`
};

const Root = styled('div')({
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
    [`& .${classes.avatar}`]: {
        margin: "1em",
        display: "flex",
        justifyContent: "center",
    },
    [`& .${classes.icon}`]: {
    },
    [`& .${classes.hint}`]: {
        marginTop: "1em",
        display: "flex",
        justifyContent: "center",
    },
    [`& .${classes.form}`]: {
        padding: "0 1em 1em 1em",
    },
    [`& .${classes.input}`]: {
        marginTop: "1em",
    },
    [`& .${classes.actions}`]: {
        padding: "0 1em 1em 1em",
    },
});

function MyLoginPage(props) {


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
              <LockIcon />
            </Avatar>
          </div>
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
          <CardActions className={classes.actions}>
              <Button
                  variant="contained"
                  type="submit"
                  color="primary"
                  className={classes.button}
                  fullWidth
              >
                  {translate('ra.auth.sign_in')}
              </Button>
              </CardActions>
      </form>
      </Card>
  <Notification />
  </Root>
  );
}

export default MyLoginPage;
