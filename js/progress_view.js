
// <!--  // created by duangan, 2017-08-13   -->
// <!--  // support progress view. -->

var Progress_view = {
    createNew: function(){
        var progress = {};
        progress.mWidth = 500;               // 进度条的总长度，单位 px 
        progress.mTotal = 0;                 // 需要操作的总步数 
        progress.mPix = 0;                   // 每步所占的进度条单位长度(仅支持每步均等的情况)
        progress.mProgress = 0;              // 当前进度条长度
        
        progress.mStatusView = "";
        progress.mBorderView = "";
        progress.mProgressView = "";
        progress.mPercentView = "";
        
        // 初始化
        progress.init = function(width, total, status, border, 
                progress, percent){
            mWidth = width;
            mTotal = total;
            if (total > 0) {
                mPix = width / total;
            }
            mStatusView = status;
            mBorderView = border;
            mProgressView = progress;
            mPercentView = percent;
        };
        
        // 更新进度条界面
        progress.update = function(message, step) 
        {
            if (step * mPix > mWidth) {
                mProgress = mWidth;
            } else {
                mProgress = step * mPix;
            }
            document.getElementById(mStatusView).style.display = "inline";
            // document.getElementById(mBorderView).style.display = "inline";
            // document.getElementById(mProgressView).style.display = "inline";
            document.getElementById(mPercentView).style.display = "inline";
            
            document.getElementById(mStatusView).innerHTML = message; 
            document.getElementById(mProgressView).style.width = mProgress + "px"; 
            document.getElementById(mPercentView).innerHTML = 
                parseInt(mProgress / mWidth * 100) + "%";
        };
        
        progress.getTotal = function()
        {
            return mTotal;
        };
        
        return progress;
    }
};