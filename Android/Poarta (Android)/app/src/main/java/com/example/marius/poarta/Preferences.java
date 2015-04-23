package com.example.marius.poarta;

import android.content.Context;
import android.content.SharedPreferences;
import android.support.v7.app.ActionBarActivity;
import android.os.Bundle;
import android.text.Editable;
import android.text.TextWatcher;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Toast;


public class Preferences extends ActionBarActivity{
    EditText etIp, etPort, etUsername, etPassword;
    SharedPreferences sp;
    Button bSave;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_preferences);
        sp = getSharedPreferences("prefs", Context.MODE_PRIVATE);
        String ip, port, username, password;
        ip = sp.getString("ip", null);
        port = sp.getString("port", null);
        username = sp.getString("username", null);
        password = sp.getString("password", null);

        etIp = (EditText) findViewById(R.id.etIP);
        etPort = (EditText) findViewById(R.id.etPort);
        etUsername = (EditText) findViewById(R.id.etUsername);
        etPassword = (EditText) findViewById(R.id.etPassword);
        bSave = (Button) findViewById(R.id.bSave);

        getSupportActionBar().setDisplayHomeAsUpEnabled(true);

        bSave.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                SharedPreferences.Editor e = sp.edit();
                String ip, port, username, password;
                ip = etIp.getText().toString();
                port = etPort.getText().toString();
                username = etUsername.getText().toString();
                password = etPassword.getText().toString();

                e.putString("ip", ip);
                e.putString("port", port);
                e.putString("username", username);
                e.putString("password", password);

                e.commit();

                Toast.makeText(Preferences.this, "Date Salvate", Toast.LENGTH_LONG).show();
            }
        });


        if(ip != null) {
            etIp.setText(ip);
        }

        if(port != null) {
            etPort.setText(port);
        }

        if(username != null) {
            etUsername.setText(username);
        }

        if(password != null) {
            etPassword.setText(password);
        }


    }

    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        if(item.getItemId() == android.R.id.home) {
            finish();
        }
        return super.onOptionsItemSelected(item);
    }
}
