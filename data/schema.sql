DROP TABLE IF EXISTS certificate;

CREATE TABLE certificate (id INTEGER PRIMARY KEY AUTOINCREMENT, isin VARCHAR(50) NOT NULL, tradingMarket VARCHAR(50) NOT NULL, issuer VARCHAR(100) NOT NULL, currency varchar(10) NOT NULL, issuingPrice INTEGER NOT NULL, currentPrice INTEGER NOT NULL, barrier INTEGER, participationRate REAL, priceHistory TEXT, additionalDocument TEXT);

INSERT INTO certificate (isin, tradingMarket, issuer, currency, issuingPrice, currentPrice)
VALUES ('TESTISIN0001', 'Germany', 'Sparkasse', 'EUR', 10000, 10000);

INSERT INTO certificate (isin, tradingMarket, issuer, currency, issuingPrice, currentPrice)
VALUES ('TESTISIN0002', 'Germany', 'Deutsche Bank', 'EUR', 20000, 20000);

INSERT INTO certificate (isin, tradingMarket, issuer, currency, issuingPrice, currentPrice)
VALUES ('TESTISIN0003', 'Germany', 'Commerzbank', 'EUR', 30000, 30000);

INSERT INTO certificate (isin, tradingMarket, issuer, currency, issuingPrice, currentPrice)
VALUES ('TESTISIN0004', 'Germany', 'KfW', 'EUR', 40000, 40000);