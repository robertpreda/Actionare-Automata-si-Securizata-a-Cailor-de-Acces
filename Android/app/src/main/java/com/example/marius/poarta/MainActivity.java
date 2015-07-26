package com.example.marius.poarta;

import android.app.AlertDialog;
import android.app.PendingIntent;
import android.app.ProgressDialog;
import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.content.IntentFilter;
import android.content.SharedPreferences;
import android.nfc.NfcAdapter;
import android.nfc.Tag;
import android.os.Bundle;
import android.provider.Settings;
import android.support.v7.app.ActionBarActivity;
import android.view.LayoutInflater;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Button;
import android.widget.Toast;

public class MainActivity extends ActionBarActivity implements View.OnClickListener {
    private static final String TAG = "NFCReadTag";
    Button bOpen, bClose, bAuto, bPause;
    String ip, port, username, password;
    SharedPreferences sp;

    private NfcAdapter mNfcAdapter;
    private IntentFilter[] mNdefExchangeFilters;
    private PendingIntent mNfcPendingIntent;

    private Communicator communicator;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);
        communicator = new Communicator(this, true);

        username = communicator.getUsername();
        password = communicator.getPassword();
        ip = communicator.getIp();

        if (username == null || password == null || ip == null || username == "" || password == "" || ip == "") {
            Intent i = new Intent(this, Preferences.class);
            startActivity(i);
        }

        bOpen = (Button) findViewById(R.id.bOpen);
        bClose = (Button) findViewById(R.id.bClose);
        bAuto = (Button) findViewById(R.id.bAuto);
        bPause = (Button) findViewById(R.id.bPause);

        bOpen.setOnClickListener(this);
        bClose.setOnClickListener(this);
        bAuto.setOnClickListener(this);
        bPause.setOnClickListener(this);


    }


    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        // Inflate the menu; this adds items to the action bar if it is present.
        getMenuInflater().inflate(R.menu.menu_main, menu);
        return true;
    }

    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        // Handle action bar item clicks here. The action bar will
        // automatically handle clicks on the Home/Up button, so long
        // as you specify a parent activity in AndroidManifest.xml.
        int id = item.getItemId();

        //noinspection SimplifiableIfStatement
        if (id == R.id.action_settings) {
            Intent i = new Intent(this, Preferences.class);
            startActivity(i);
        }

        return super.onOptionsItemSelected(item);
    }

    @Override
    protected void onResume() {
        super.onResume();

        mNfcAdapter = NfcAdapter.getDefaultAdapter(this);
        mNfcPendingIntent = PendingIntent.getActivity(this, 0, new Intent(this,
                getClass()).addFlags(Intent.FLAG_ACTIVITY_SINGLE_TOP
                | Intent.FLAG_ACTIVITY_CLEAR_TOP), 0);
        IntentFilter smartwhere = new IntentFilter(NfcAdapter.ACTION_TAG_DISCOVERED);
        mNdefExchangeFilters = new IntentFilter[]{smartwhere};

        if (mNfcAdapter != null) {
            mNfcAdapter.enableForegroundDispatch(this, mNfcPendingIntent,
                    mNdefExchangeFilters, null);
            if (!mNfcAdapter.isEnabled()) {
                LayoutInflater inflater = getLayoutInflater();
                View dialoglayout = inflater.inflate(R.layout.nfc_settings_layout, (ViewGroup) findViewById(R.id.nfc_settings_layout));
                new AlertDialog.Builder(this).setView(dialoglayout)
                        .setPositiveButton("Setari NFC", new DialogInterface.OnClickListener() {
                            public void onClick(DialogInterface arg0, int arg1) {
                                Intent setnfc = new Intent(Settings.ACTION_NFC_SETTINGS);
                                startActivity(setnfc);
                            }
                        })
                        .setOnCancelListener(new DialogInterface.OnCancelListener() {
                            public void onCancel(DialogInterface dialog) {
                               // finish(); // exit application if user cancels
                            }
                        }).create().show();
            }
        } else {
            Toast.makeText(getApplicationContext(), "Adaptor NFC inexistent", Toast.LENGTH_SHORT).show();
        }
    }

    @Override
    protected void onPause() {
        super.onPause();

        if (mNfcAdapter != null) mNfcAdapter.disableForegroundDispatch(this);
    }

    @Override
    protected void onNewIntent(Intent intent) {
        super.onNewIntent(intent);
        if (NfcAdapter.ACTION_TAG_DISCOVERED.equals(intent.getAction())) {
            Tag tag = intent.getParcelableExtra(NfcAdapter.EXTRA_TAG);
            String id = bytesToHexString(tag.getId());
            if (id.equals(new String("0xd467e96d"))) {
                communicator.automaticGate();
            } else {
                Toast.makeText(this, "Tag nerecunoscut", Toast.LENGTH_LONG).show();
            }
        }
    }

    private String bytesToHexString(byte[] src) {
        StringBuilder stringBuilder = new StringBuilder("0x");
        if (src == null || src.length <= 0) {
            return null;
        }

        char[] buffer = new char[2];
        for (int i = 0; i < src.length; i++) {
            buffer[0] = Character.forDigit((src[i] >>> 4) & 0x0F, 16);
            buffer[1] = Character.forDigit(src[i] & 0x0F, 16);
            System.out.println(buffer);
            stringBuilder.append(buffer);
        }

        return stringBuilder.toString();
    }

    @Override
    public void onClick(View v) {
        int id = v.getId();
        switch (id) {
            case R.id.bOpen:
                communicator.openGate();
                break;

            case R.id.bClose:
                communicator.closeGate();
                break;

            case R.id.bAuto:
                communicator.automaticGate();
                break;

            case R.id.bPause:
                communicator.pauseGate();
                break;

        }

    }
}