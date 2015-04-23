package com.example.marius.poarta;

import android.app.AlertDialog;
import android.app.PendingIntent;
import android.app.ProgressDialog;
import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.content.IntentFilter;
import android.content.SharedPreferences;
import android.nfc.NdefMessage;
import android.nfc.NfcAdapter;
import android.nfc.Tag;
import android.nfc.tech.MifareUltralight;
import android.os.Parcelable;
import android.os.PatternMatcher;
import android.provider.Settings;
import android.support.v7.app.ActionBarActivity;
import android.os.Bundle;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Button;
import android.widget.Toast;
import org.jsoup.nodes.Document;

import org.jsoup.Jsoup;
import org.jsoup.nodes.Element;

import java.io.IOException;
import java.nio.charset.Charset;


public class MainActivity extends ActionBarActivity implements View.OnClickListener {
    Button bOpen, bClose, bAuto, bPause;
    Document document;
    String ip, port, username, password;
    SharedPreferences sp;
    String urlCode, code, urlSendCommand;

    Context context;
    Intent intent;
    ProgressDialog dialog;

    private static final String TAG = "NFCReadTag";
    private NfcAdapter mNfcAdapter;
    private IntentFilter[] mNdefExchangeFilters;
    private PendingIntent mNfcPendingIntent;

    Runnable threadRunnable = new Runnable() {
        @Override
        public void run() {
            try {
                org.jsoup.nodes.Document document;
                document = Jsoup.connect(urlCode).timeout(15000).get();
                Element body = document.body();
                code = body.text();
                stopProgressDialog();
            } catch (IOException e) {
                e.printStackTrace();
            }
        }
    };

    Runnable sendCommandRunnable = new Runnable() {
        @Override
        public void run() {
            try {
                Document document = Jsoup.connect(urlSendCommand).get();
                Thread t = new Thread(threadRunnable);
                t.start();
                //startActivity(intent);
            } catch (IOException e) {
                e.printStackTrace();
            }
        }
    };
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        sp = getSharedPreferences("prefs", Context.MODE_PRIVATE);
        ip = sp.getString("ip", null);
        port = sp.getString("port", null);
        username = sp.getString("username", null);
        password = sp.getString("password", null);
        setContentView(R.layout.activity_main);



        if(username == null || password == null || ip == null || username == "" || password == "" || ip == "") {
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

        context = this;
        intent = getIntent();

        urlCode = "http://"+ip+"/test/test.php";

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
        buildProgress();
        Thread t = new Thread(threadRunnable);
        t.start();

        mNfcAdapter = NfcAdapter.getDefaultAdapter(this);
        mNfcPendingIntent = PendingIntent.getActivity(this, 0, new Intent(this,
                getClass()).addFlags(Intent.FLAG_ACTIVITY_SINGLE_TOP
                | Intent.FLAG_ACTIVITY_CLEAR_TOP), 0);
        IntentFilter smartwhere = new IntentFilter(NfcAdapter.ACTION_TAG_DISCOVERED);
        mNdefExchangeFilters = new IntentFilter[] { smartwhere };

        if(mNfcAdapter != null) {
            mNfcAdapter.enableForegroundDispatch(this, mNfcPendingIntent,
                    mNdefExchangeFilters, null);
            if (!mNfcAdapter.isEnabled()){
                LayoutInflater inflater = getLayoutInflater();
                View dialoglayout = inflater.inflate(R.layout.nfc_settings_layout,(ViewGroup) findViewById(R.id.nfc_settings_layout));
                new AlertDialog.Builder(this).setView(dialoglayout)
                        .setPositiveButton("Update Settings", new DialogInterface.OnClickListener() {
                            public void onClick(DialogInterface arg0, int arg1) {
                                Intent setnfc = new Intent(Settings.ACTION_WIRELESS_SETTINGS);
                                startActivity(setnfc);
                            }
                        })
                        .setOnCancelListener(new DialogInterface.OnCancelListener() {
                            public void onCancel(DialogInterface dialog) {
                                finish(); // exit application if user cancels
                            }
                        }).create().show();
            }
        } else {
            Toast.makeText(getApplicationContext(), "Sorry, No NFC Adapter found.", Toast.LENGTH_SHORT).show();
        }
    }

    @Override
    protected void onPause() {
        super.onPause();

        if(mNfcAdapter != null) mNfcAdapter.disableForegroundDispatch(this);
    }

    @Override
    protected void onNewIntent(Intent intent) {
        super.onNewIntent(intent);
        stopProgressDialog();
        if (NfcAdapter.ACTION_TAG_DISCOVERED.equals(intent.getAction())) {
            Tag tag=intent.getParcelableExtra(NfcAdapter.EXTRA_TAG);
            String id = bytesToHexString(tag.getId());
            if(id.equals(new String("0xd467e96d"))) {
                buildProgress();
                urlSendCommand = "http://" + ip + ":" + port + "/test/cineIntra.php?user=" + username + "&token=";
                urlSendCommand += MD5(username + password + code + "3");
                Thread sendCommand = new Thread(sendCommandRunnable);
                sendCommand.start();
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
        buildProgress();
        urlSendCommand = "http://"+ip+":"+port+"/test/cineIntra.php?user="+username+"&token=";
        int id = v.getId();
        switch (id) {
            case R.id.bOpen:
                urlSendCommand += MD5(username+password+code+"1");
                break;

            case R.id.bClose:
                urlSendCommand += MD5(username+password+code+"2");
                break;

            case R.id.bAuto:
                urlSendCommand += MD5(username+password+code+"3");
                break;

            case R.id.bPause:
                urlSendCommand += MD5(username+password+code+"4");
                break;
        }
        Thread sendCommand = new Thread(sendCommandRunnable);
        sendCommand.start();
        //Thread getCode = new Thread(threadRunnable);
        //getCode.start();

    }

    public String MD5(String md5) {
        try {
            java.security.MessageDigest md = java.security.MessageDigest.getInstance("MD5");
            byte[] array = md.digest(md5.getBytes());
            StringBuffer sb = new StringBuffer();
            for (int i = 0; i < array.length; ++i) {
                sb.append(Integer.toHexString((array[i] & 0xFF) | 0x100).substring(1,3));
            }
            return sb.toString();
        } catch (java.security.NoSuchAlgorithmException e) {
        }
        return null;
    }

    private void buildProgress() {
        //dialog = ProgressDialog.show(this, "",
          //      "Loading. Please wait...", true);
        dialog = ProgressDialog.show(this, "",
                "Se așteaptă răspuns de la poartă. Vă rugăm așteptați...", true);
        dialog.setCancelable(true);
    }

    private void stopProgressDialog() {
        if(dialog.isShowing()) {
            dialog.dismiss();
        }
    }


}
