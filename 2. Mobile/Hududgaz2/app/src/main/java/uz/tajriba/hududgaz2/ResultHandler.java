package uz.tajriba.hududgaz2;

import android.app.Activity;
import android.view.View;
import android.widget.Button;

import androidx.annotation.NonNull;

import com.google.android.material.snackbar.Snackbar;

import org.json.JSONException;
import org.json.JSONObject;

import java.io.IOException;

import okhttp3.Call;
import okhttp3.Callback;
import okhttp3.MediaType;
import okhttp3.OkHttpClient;
import okhttp3.Request;
import okhttp3.RequestBody;
import okhttp3.Response;


public class ResultHandler {

    View context;
    Button btn_rec, btn_sys, btn_doc;
    OkHttpClient client;

    private boolean SYSTEM_SCANNED = false;
    private boolean DOCUMENT_SCANNED = false;

    private final LoadingDialog loader;
    private JSONObject data;

    private String url = null;
    private String btn_text = null;

    public ResultHandler(Activity activity, Button btn_rec, Button btn_sys, Button btn_doc) {
        this.btn_rec = btn_rec;
        this.btn_sys = btn_sys;
        this.btn_doc = btn_doc;
        this.context = (View) btn_rec.getParent();
        this.loader = new LoadingDialog(activity);

        btn_rec.setOnClickListener(this::recoveryClick);

        this.client = new OkHttpClient();
        this.data = new JSONObject();
    }

    public void resultCheck(String result, View btn_sys, View btn_doc) {
        try {
            JSONObject json = new JSONObject(result);
            if (json.has("url") && json.has("token")) {
                this.url = json.getString("url");
                this.data.put("token", json.getString("token"));

                btn_sys.setEnabled(false);
                SYSTEM_SCANNED = true;
            }
        } catch (JSONException e) {
            try {
                this.data.put("code", result);

                btn_doc.setEnabled(false);
                DOCUMENT_SCANNED = true;
            } catch (JSONException e1) {
                e1.printStackTrace();
            }

            e.printStackTrace();
        }

        if (SYSTEM_SCANNED && DOCUMENT_SCANNED) {
            createDocument(url, data.toString()); // "{\"code\":\"" + code + "\"}"
        }
    }

    public void btnClick(Button btn) {
        btn_text = btn.getText().toString();
    }

    public String getTitle() {
        return String.format("%sNI TEKSHIRING", btn_text.toUpperCase());
    }

    private void createDocument(String url, String data) {
        showLoader();

        MediaType mediaType = MediaType.get("application/json; charset=utf-8");
        RequestBody body = RequestBody.create(data, mediaType);

        Request request = new Request.Builder()
                .url(url).post(body).build();

        client.newCall(request).enqueue(new Callback() {
            @Override
            public void onFailure(@NonNull Call call, @NonNull IOException e) {
                hideLoader();
                System.out.println(e.getMessage());

                Snackbar.make(context, "Xatolik", Snackbar.LENGTH_SHORT).show();
            }

            @Override
            public void onResponse(@NonNull Call call, @NonNull Response response) throws IOException {
                hideLoader();
                String str = response.body().string();

                System.out.println(str);
                Snackbar.make(context, str, Snackbar.LENGTH_SHORT).show();
            }
        });

        btn_rec.setVisibility(View.VISIBLE);
    }

    private void recoveryClick(View view) {
        view.setVisibility(View.INVISIBLE);
        btn_sys.setEnabled(true);
        btn_doc.setEnabled(true);

        data = new JSONObject();
        DOCUMENT_SCANNED = false;
        SYSTEM_SCANNED = false;
    }

    private void showLoader() {
        this.loader.startLoadingDialog();
    }

    private void hideLoader() {
        this.loader.dismissDialog();
    }
}
