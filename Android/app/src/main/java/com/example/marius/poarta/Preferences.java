package com.example.marius.poarta;

import android.content.SharedPreferences;
import android.os.Bundle;
import android.preference.PreferenceManager;
import android.support.v7.app.ActionBarActivity;
import android.view.MenuItem;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Toast;


public class Preferences extends ActionBarActivity {
    EditText etIp, etPort, etUsername, etPassword;
    SharedPreferences sp;
    Button bSave;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_preferences);
        sp = PreferenceManager.getDefaultSharedPreferences(getApplicationContext());
        String ip = null, port = null, username = null, password = null;
        try {
            ip = sp.getString("ip", "");
            port = sp.getString("port", "");
            username = sp.getString("username", "");
            password = sp.getString("password", "");
        } catch (Exception e) {
            e.printStackTrace();
        }

        etIp = (EditText) findViewById(R.id.etIP);
        etPort = (EditText) findViewById(R.id.etPort);
        etUsername = (EditText) findViewById(R.id.etUsername);
        etPassword = (EditText) findViewById(R.id.etPassword);
        bSave = (Button) findViewById(R.id.bSave);

        getSupportActionBar().setDisplayHomeAsUpEnabled(true);

        bSave.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                String ip, port, username, password;
                ip = etIp.getText().toString();
                port = etPort.getText().toString();
                username = etUsername.getText().toString();
                password = etPassword.getText().toString();

                try {
                    SharedPreferences.Editor e = sp.edit();
                    e.putString("ip", ip);
                    e.putString("port", port);
                    e.putString("username", username);
                    e.putString("password", password);
                    e.commit();
                } catch (Exception e1) {
                    e1.printStackTrace();
                }

                Toast.makeText(Preferences.this, "Date Salvate", Toast.LENGTH_LONG).show();
            }
        });


        if (ip != null) {
            etIp.setText(ip);
        }

        if (port != null) {
            etPort.setText(port);
        }

        if (username != null) {
            etUsername.setText(username);
        }

        if (password != null) {
            etPassword.setText(password);
        }


    }

    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        if (item.getItemId() == android.R.id.home) {
            finish();
        }
        return super.onOptionsItemSelected(item);
    }
}
