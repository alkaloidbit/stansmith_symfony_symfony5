import React from "react";
import { styled } from '@mui/material/styles';
import { Link } from "react-router-dom";
import ImageIcon from "@mui/icons-material/ImageTwoTone";
import { Button } from "react-admin";

const PREFIX = 'AddMediaObjectButton';

const classes = {
  button: `${PREFIX}-button`
};

const StyledButton = styled(Button)({
  [`&.${classes.button}`]: {
    marginTop: "1em",
    marginBottom: "1em",
  },
});

const AddMediaObjectButton = ({  record }) => {
console.log();
  return (
    <StyledButton
      className={classes.button}
      variant="contained"
      component={Link}
      to={{
        pathname: "/media_objects/create",
        // Here we specify the initial record for the create view
        state: { record: record }
      }}
      label="Add a MediaObject"
      title="Add a MediaObject"
    >
      <ImageIcon />
    </StyledButton>
  );
};

export default (AddMediaObjectButton);
