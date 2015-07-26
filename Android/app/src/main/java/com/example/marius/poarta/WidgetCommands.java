package com.example.marius.poarta;

import android.app.PendingIntent;
import android.appwidget.AppWidgetManager;
import android.appwidget.AppWidgetProvider;
import android.content.ComponentName;
import android.content.Context;
import android.content.Intent;
import android.widget.RemoteViews;


/**
 * Implementation of App Widget functionality.
 */
public class WidgetCommands extends AppWidgetProvider {
    public static final String ACTION_OPEN = "com.example.marius.poarta.DESCHIDE";
    public static final String ACTION_CLOSE = "com.example.marius.poarta.INCHIDE";
    public static final String ACTION_AUTO = "com.example.marius.poarta.AUTO";
    public static final String ACTION_PAUSE = "com.example.marius.poarta.PAUZA";

    public static PendingIntent buildButtonPendingIntent(Context context, int id) {
        Intent intent = new Intent();
        switch (id) {
            case R.id.bOpenW:
                intent.setAction(ACTION_OPEN);
                break;

            case R.id.bCloseW:
                intent.setAction(ACTION_CLOSE);
                break;

            case R.id.bAutoW:
                intent.setAction(ACTION_AUTO);
                break;

            case R.id.bPauseW:
                intent.setAction(ACTION_PAUSE);
                break;

        }
        return PendingIntent.getBroadcast(context, 0, intent, PendingIntent.FLAG_UPDATE_CURRENT);
    }

    public static void pushWidgetUpdate(Context context, RemoteViews remoteViews) {
        ComponentName myWidget = new ComponentName(context, WidgetCommands.class);
        AppWidgetManager manager = AppWidgetManager.getInstance(context);
        manager.updateAppWidget(myWidget, remoteViews);
    }

    static void updateAppWidget(Context context, AppWidgetManager appWidgetManager,
                                int appWidgetId) {

        CharSequence widgetText = context.getString(R.string.appwidget_text);
        // Construct the RemoteViews object
        RemoteViews views = new RemoteViews(context.getPackageName(), R.layout.widget_deschidere);
        // Instruct the widget manager to update the widget
        appWidgetManager.updateAppWidget(appWidgetId, views);
    }

    @Override
    public void onUpdate(Context context, AppWidgetManager appWidgetManager, int[] appWidgetIds) {
        // There may be multiple widgets active, so update all of them
        RemoteViews remoteViews = new RemoteViews(context.getPackageName(), R.layout.widget_deschidere);

        remoteViews.setOnClickPendingIntent(R.id.bOpenW, buildButtonPendingIntent(context, R.id.bOpenW));
        remoteViews.setOnClickPendingIntent(R.id.bCloseW, buildButtonPendingIntent(context, R.id.bCloseW));
        remoteViews.setOnClickPendingIntent(R.id.bAutoW, buildButtonPendingIntent(context, R.id.bAutoW));
        remoteViews.setOnClickPendingIntent(R.id.bPauseW, buildButtonPendingIntent(context, R.id.bPauseW));

        pushWidgetUpdate(context, remoteViews);/*
        final int N = appWidgetIds.length;
        for (int i = 0; i < N; i++) {
            updateAppWidget(context, appWidgetManager, appWidgetIds[i]);
        }*/

    }

    @Override
    public void onEnabled(Context context) {
        // Enter relevant functionality for when the first widget is created
    }

    @Override
    public void onDisabled(Context context) {
        // Enter relevant functionality for when the last widget is disabled
    }
}

