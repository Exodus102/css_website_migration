
from flask import Flask, request, jsonify
import json
import os
from transformers import XLMRobertaTokenizer, XLMRobertaForSequenceClassification, XLMRobertaConfig
import torch

# Define the model_save_path_combined variable
model_save_path_combined = "./fine_tuned_xlm_roberta_sentiment_combined_dataset/fine_tuned_xlm_roberta_sentiment_combined_dataset"

# Define the label_map dictionary
label_map = {0: "Negative", 1: "Neutral", 2: "Positive"}

def load_model_and_tokenizer():
    print(f"Attempting to load model and tokenizer from: {model_save_path_combined}")
    try:
        config_path = os.path.join(model_save_path_combined, "config.json")
        if not os.path.exists(config_path):
            raise FileNotFoundError(f"config.json not found at {config_path}")

        with open(config_path, 'r', encoding='utf-8') as f:
            raw_config_dict = json.load(f)

        specific_config = XLMRobertaConfig(**raw_config_dict)
        tokenizer = XLMRobertaTokenizer.from_pretrained(model_save_path_combined)
        model = XLMRobertaForSequenceClassification.from_pretrained(model_save_path_combined, config=specific_config)
        model.eval()

        print("Model and tokenizer loaded successfully!")
        return tokenizer, model

    except Exception as e:
        print(f"Error loading model or tokenizer: {e}")
        return None, None

def predict_sentiment(text, tokenizer, model, label_map):
    if tokenizer is None or model is None:
        return "Error: Model or tokenizer not loaded."

    inputs = tokenizer(
        text,
        return_tensors='pt',
        padding=True,
        truncation=True
    )

    with torch.no_grad():
        outputs = model(**inputs)

    predicted_class_idx = torch.argmax(outputs.logits, dim=-1).item()
    predicted_sentiment = label_map.get(predicted_class_idx, f"Unknown Label {predicted_class_idx}")
    return predicted_sentiment


app = Flask(__name__)

# Load model and tokenizer globally when the app starts
tokenizer_global, model_global = load_model_and_tokenizer()

@app.route('/predict', methods=['POST'])
def predict():
    if request.method == 'POST':
        data = request.get_json()
        if not data or 'text' not in data:
            return jsonify({'error': 'Please provide a JSON object with a "text" field.'}), 400

        text_to_predict = data['text']

        if tokenizer_global is None or model_global is None:
            return jsonify({'error': 'Model and tokenizer could not be loaded.'}), 500

        sentiment = predict_sentiment(text_to_predict, tokenizer_global, model_global, label_map)
        return jsonify({'text': text_to_predict, 'sentiment': sentiment})

if __name__ == '__main__':
    # For local execution, run with: python app.py
    # Make sure you have flask installed: pip install Flask
    # And the transformers library: pip install transformers torch sentencepiece
    app.run(debug=True, host='0.0.0.0', port=5000)
